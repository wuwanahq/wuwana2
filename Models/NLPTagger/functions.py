"""
NLP WUWANA CLASS
@author: Oscar Fernández Vicente / ofvicente@gmail.com
jan/21
"""

from gensim.summarization import keywords
from spacy.lang.char_classes import ALPHA, ALPHA_LOWER, ALPHA_UPPER, CONCAT_QUOTES, LIST_ELLIPSES, LIST_ICONS
from spacy.util import compile_infix_regex
from spacy.tokenizer import Tokenizer
from google_trans_new import google_translator  
import re
import math
import json
import spacy
import wordcloud
import sys
import time
import string

class NLP_Wuwana():
        
    def __init__(self, 
        db,
        languages,
        weight_field ,
        spacy_model,
        remove_words = "./data/words_to_remove.txt", 
        replace_words= "./data/words_to_replace.txt",
        desc_field = "description", 
        max_words = 5,
        ):

        """Class defined to process wuwana description tags. It attacks db and uses 3 NLP Libraries:
        - Spacy as tokenizer.
        - Wordcloud as tag modeller.
        - Gensim as tag modeller.
        

        Parameters
        -----------
        languages: list with languages in format: ["es","fr","zh-cn"]
        remove_words: path to file of words to be removed.
        replace_words: path to file of words to be replaced.
        spacy_mode: pretrained Spacy model. 
        max_words: max words to be extracted from description texts.
        desc_field: field where text is stored in company table.
        weight_field: Field in company table where weights will be stored.
       
        """

        #file with words to be removed from tags
        self.file_words = open(remove_words, "r", encoding="utf-8" )
        self.remove_words = self.file_words.read().split(";")    

        #bag of words that should be replaced, such as abbreviations
        with open(replace_words, "r", encoding="utf-8" ) as f_in:
            self.replace_words = json.load(f_in)
        
        self.translator = google_translator()  
        self.db = db
        self.cursor_tag = self.db.cursor()
        self.max_words = max_words
        self.desc_field = desc_field
        self.languages = languages
        self.weight_field = weight_field

        # English pretrained Spacy model 
        try:
            self.nlp = spacy.load("en_core_web_lg")
        except: sys.exit("ERROR: You must download en_core_web_lg spacy model. Use 'python -m spacy download en_core_web_lg' ")
               
        

    ########
    #MAIN##
    ########

    def process_query_companies(self, lib, onlyid=False, column_pos = 1):
        """ Function that launch a sql query and extract main tags from column
        
        Parameters
        -----------
        lib: NLP Lib to use (Gensim or Wordcloud)
        onlyid: Check if changes only applied to one company id
        column_pos: position of the first column to extract text
        
        """
                
        if(onlyid):
            query = "select company.ID, company."+str(self.desc_field)+" from company where ID = '"+str(onlyid)+"'"
        else:
            query = "select company.ID, company."+str(self.desc_field)+" from company "
                
        if((lib!= "gensim") & (lib!= "wordcloud")):
            sys.exit("ERROR: Unknown library: "+str(lib))
        else:
            pass                
        
        updates_list = []        

        try:
             # Execute the SQL command
            cursor = self.db.cursor()
            result = cursor.execute(query)
            self.db.commit()
        except Exception as e:
            print("ERROR LOADING DB ", str(e))
            pass
        
        n=0
        if(result):
            rows = cursor.fetchall()
            print("Processing "+str(result)+" companies.")

            for row in rows:
                
                try:
                    
                    text = row[column_pos] 
                    nouns_ex = self.process_text(text, lib)                    
                    tags_english = self.get_keywords(nouns_ex, self.max_words, lib=lib)
                    
                    if(tags_english):
                        
                        
                        tags_main = dict()
                        tags_all = dict()

                        tags_english_split = tags_english[1].split(";")

                        for l in self.languages:
                            
                            tags_main[l] = self.get_first_text(self.get_translation(tags_english[0], lang=l))
                            tags_all[l] = self.get_first_text(self.get_translation(tags_english[1], lang=l))
                            
                            tag_list = []

                        main_tag = False
                        second_tag = False
                        other_tags = False
                            
                        for x in range(0, len(tags_english_split)):

                            if(len(tags_english_split[x])>0):
                                for s in tags_all.keys():
                                    try:
                                        tag_split = tags_all[s].split(";")[x].strip()
                                        
                                    except: tag_split = "-"

                                    tag_list.append(tag_split)

                                self.check_and_insert_tag_v2(tags_english_split[x], tag_list)
                                tag_list = []
                            
                            if(x==0):
                                main_tag = tags_english_split[x].strip()
                            elif(x==1):
                                second_tag = tags_english_split[x].strip()
                            elif(x==2):
                                other_tags = tags_english_split[x].strip()
                            else:
                                other_tags += ";"+tags_english_split[x].strip()
                                                                               
                        updates_list.append(self.update_company_tags(main_tag, row[0], tags_english[2], second_tag, other_tags ))                                                                                        
                                                
                    else:
                        print("WARNING: No tags extracted for ID", row[0], "with text:", text )
                        
                except Exception as e:
                    print("ERROR Processing query row: ", str(e))
                    
        else:
            print("WARNING: NO results in SQL.")

        #update tags - execute querys
        for i in updates_list:
            try:
                cursor.execute(i) 
                self.db.commit()
            except Exception as e:
                    print("Error ", str(e))


    def process_text(self, text, lib ):
        """ Function that processes a text with a pipeline of tasks, and returns transformed and cleaned text 
        to be used by NLP libs
        
        Parameters
        -----------
        text:  text to extract tags
        lib: NLP library to be used afterwards (wordcloud or gensim)
        return: cleaned and transformed text
        """
        
        #remove hastags, mentions, and links
        text = self.strip_all_entities(self.strip_links(text))
        #remove special chars
        text = self.remove_special_characters(text)
        #remove emojis
        text = self.remove_emojis(text)
        #detect source lang and translate to english if necessary
        source_lang = self.detect_lang(text)
        
        if source_lang: 
            if source_lang != 'en':
                text = self.get_translation(text)
            
        else:
            print("WARNING: No specific language detected. Translating sentences (slow)")
            text = self.translate_sentence_by_sentence(text)
            
        #to lowercase        
        text = text.lower()
        
        # Spacy model and custom tokenizer

        self.nlp.tokenizer = self.custom_tokenizer()
        sentence = ''
        
        if(lib == "wordcloud"):
        
            #get nouns longer than 1 char
            for word in self.nlp(text):
                if ((word.pos_ in ['NOUN']) & (len(word.text)>1)):
                    sentence += word.text + ' '
            #replace some words with others
            sentence = self.replace_dict(sentence)
            #remove specific words and lemmatize
            sentence = self.remove_common(sentence)
            #last nouns filter
            fin_sent = ''
            for word in self.nlp(sentence):
                if word.pos_ in ["NOUN"]:
                    fin_sent += word.text + ' '
                    
        elif(lib == "gensim"):

            #get nouns and adjetives longer than 1 char  
            for word in self.nlp(text):
                if((word.pos_ in ["NOUN", "ADJ"]) & (len(word.text)>1)):
                    sentence += word.text + ' '
            
            #replace some words with others
            sentence = self.replace_dict(sentence)
            #remove specific words and lemmatize
            sentence = self.remove_common(sentence)            
            fin_sent = sentence
        
        else:
            sys.exit("ERROR: LIB NOT FOUND: "+str(lib))
            
        return fin_sent

    ########
    #MYSQL##
    ########
        
    def update_company_tags(self, first_tag, idcomp, weights, second_tag=False, other_tags=False):
        """Creates SQL Query for update the tag table
        Parameters
        -----------
        first_tag:  main tag
        idcomp: id of company 
        weights: weights of every tag
        second_tag: the second tag most relevant
        other_tags: rest of tags
        
        return: sql query to update
        
        """

        weights = self.get_weight_string(weights)

        print(idcomp, weights)
        
        if(other_tags):
            sql_upd = "UPDATE company set FirstTagID='{0}', SecondTagID='{1}', OtherTags = '{2}', {5} = '{4}'  where ID = {3}".format(first_tag, second_tag, other_tags, idcomp, weights, self.weight_field)
        elif(second_tag):
            sql_upd = "UPDATE company set FirstTagID='{0}', SecondTagID='{1}', OtherTags = '', {4} = '{3}'  where ID = {2}".format(first_tag, second_tag, idcomp, weights, self.weight_field)
        else:
            sql_upd = "UPDATE company set FirstTagID='{0}', SecondTagID='', OtherTags = '', {3} = '{2}' where ID = {1}".format(first_tag, idcomp, weights, self.weight_field)
      
        return(sql_upd)
    
   

    def check_and_insert_tag_v2(self, eng_tag, tags):

        """Checks if tag exists in table tag and creates if not

        Parameters
        -----------
        eng_tag: Tag in english
        tags: Rest languages tags
        return: main tag

        """
        
        tag_compo = ""
        
        for i in tags:
            tag_compo += i+";"            
        sql_tag = "Insert into tag (ID, Names) values ('{0}', '{1}') ".format(eng_tag.lower(), tag_compo.lower())


        try:
            sql_tag = "Select * from tag where ID = '{0}'".format(eng_tag)
            count = self.cursor_tag.execute(sql_tag)
    
            if(count==0):#not exists
    
                sql_tag = "Insert into tag (ID, Names, Keywords) values ('{0}', '{1}', '') ".format(eng_tag, tag_compo)
                #self.cursor_tag.execute(sql_tag)
                #self.db.commit()
    
            return eng_tag    
    
        except Exception as e:
                print("ERROR: check_and_insert_tag ", str(e))



    ##########    
    ###NLP####
    ##########
        
    def detect_lang(self, text):
        """ Function that detects the language of a text
        
        Parameters
        -----------
        text:  Text to be detected
        return: lang detected
        """
        
        try:
            lang = self.translator.detect(text)[0]
            return lang
        except:
            print("WARNING: No language detected in text")
            return False
        
    def get_translation(self, text, lang="en"):  
        """ Function that translate text to english
        
        Parameters
        -----------
        text:  Text to be translated
        return: translated text
        """
        
        max_len = 4900  #library limit 5000 
        
        if(len(text)>max_len):
            
            sub_text = ""        
            for i in range(0, math.ceil(len(text) / max_len)):
                start = i * max_len
                end = (i+1)*(max_len)
                sub_text  += text[start:end] #translator.translate(text[start:end], lang_tgt='en')            
        
            text = sub_text
        else:    
            
            text = self.translator.translate(text, lang_tgt=lang)

            if(isinstance(text, list)):
                text = text[0].replace(",",";")
            else:
                text = text.replace(",",";")
        
        time.sleep(0.5) #1 second delay in order to avoid ip blocking
        return text

    def translate_sentence_by_sentence(self, text):
        """ Function that translate sentece by sentence a string to english. Separated by '.'
        
        Parameters
        -----------
        text:  Text to be translated
        return: translated text
        """
        
        sub_text = "" 
        sentences = text.split(".")
        
        for s in sentences:
            sub_text  += self.translator.translate(s, lang_tgt='en')
            
        return sub_text
            

    def replace_dict(self, sentence):
        """ Function that replace words in a sentence according to a dictionary or words (replace_words)
        
        Parameters
        -----------
        sentence:  Text to be modified
        return: cleaned text
        """
        
        sentence = sentence.lower() # convert to lower case
        
        for word, abbr in self.replace_words.items():
            sentence = sentence.replace(word.lower(), abbr)
        return sentence


    def remove_common(self, sentence):
        """ Function that remove words in a sentence according to a dictionary or words and lemmatize them (remove_words)
        
        Parameters
        -----------
        sentence:  Text to be modified
        return: cleaned text
        """

        self.nlp.tokenizer = self.custom_tokenizer()
        final_sentence = ''

        # common_words to remove
        for word in self.nlp(sentence):
            if word.lemma_.lower() not in self.remove_words:
                final_sentence += word.lemma_.lower() + ' '
        return final_sentence

    def get_weight_string(self, weights):
        """ Function that transform weight object to string.
        
        Parameters
        -----------
        weights:  Weight object returned by nlp
        return: weight transformed to string
        """

        if(isinstance(weights, dict)):#gensim
            weights = json.dumps(weights).replace("'","")
        elif(isinstance(weights, list)):#wordcloud
            weights = ', '.join(str(e).replace(",",":") for e in weights).replace("'",'"').replace("(",'').replace(")",'')
            weights = "{"+weights+"}"

        return weights

    def custom_tokenizer(self):
        """ Function that defines a tokenizer in order to be used
        
        Parameters
        -----------
        nlp:  spacy loaded object
        return: prepared tokenizer
        """
        
        infixes = (
            LIST_ELLIPSES
            + LIST_ICONS
            + [
                r"(?<=[0-9])[+\-\*^](?=[0-9-])",
                r"(?<=[{al}{q}])\.(?=[{au}{q}])".format(
                    al=ALPHA_LOWER, au=ALPHA_UPPER, q=CONCAT_QUOTES
                ),
                r"(?<=[{a}]),(?=[{a}])".format(a=ALPHA),
                #r"(?<=[{a}])(?:{h})(?=[{a}])".format(a=ALPHA, h=HYPHENS),
                r"(?<=[{a}0-9])[:<>=/](?=[{a}])".format(a=ALPHA),
            ]
        )

        infix_re = compile_infix_regex(infixes)

        return Tokenizer(self.nlp.vocab, prefix_search=self.nlp.tokenizer.prefix_search,
                                    suffix_search=self.nlp.tokenizer.suffix_search,
                                    infix_finditer=infix_re.finditer,
                                    token_match=self.nlp.tokenizer.token_match,
                                    rules=self.nlp.Defaults.tokenizer_exceptions)

    def remove_special_characters(self, text):
        """ Function that removes special characters from a text
        
        Parameters
        -----------
        text:  text to be modified
        return: cleaned text
        """

        pat = r'[^a-zA-z0-9.,!?/:;\"\'\s]' 
        return re.sub(pat, '', text)

    def remove_emojis(self, text):
        """ Function that removes emojis from a text
        
        Parameters
        -----------
        text:  text to be modified
        return: cleaned text
        """
        
        emoji_pattern = re.compile("["
                            u"\U0001F600-\U0001F64F"  # emoticons
                            u"\U0001F300-\U0001F5FF"  # symbols & pictographs
                            u"\U0001F680-\U0001F6FF"  # transport & map symbols
                            u"\U0001F1E0-\U0001F1FF"  # flags (iOS)
                            u"\U00002702-\U000027B0"
                            u"\U000024C2-\U0001F251"
                            "]+", flags=re.UNICODE)
        return emoji_pattern.sub(r'', text)

    

    def get_keywords(self, words, amount = 3, lib="wordcloud", sep=";"):
        """ Function that extract main keywords from processed text
        
        Parameters
        -----------
        words:  bag of words to extract tags
        amount: amount of of words to be extracted. 3 max words for gensim
        lib: lib to be used - gensim, wordcloud
        sep: separator for returned words 
        return: main tag, list with all tags, weighted tags
        
        """
        if(len(words) > 0):
            if(lib=="gensim"):
                
                tmp = keywords(words, words = min(amount,3), split = True )
                info = keywords(words, words = min(amount,3), scores = True )

                if(tmp):
                    return tmp[0], sep.join(tmp), info
                else:
                    return False
            elif(lib=="wordcloud"):
                listw = ""
                wcloud = wordcloud.WordCloud().generate(words)
                n=0
                if(wcloud.words_):
                    for i in wcloud.words_:
                        if(n==0):
                            main = i    
                            listw += i+sep                
                        else:
                            if(n<amount):
                                listw += i+sep
                        n+=1
                    return main, listw, wcloud.words_
                else:
                    return False
                
        else:
            #print("Warning: No words to extract tags: ", words)
            return False

        
    def strip_links(self, text):
        """ Removes urls from text
        
        Parameters
        -----------
        text: String to remove urls
        return: cleaned text
        
        """

        link_regex    = re.compile('((https?):((//)|(\\\\))+([\w\d:#@%/;$()~_?\+-=\\\.&](#!)?)*)', re.DOTALL)
        links         = re.findall(link_regex, text)
        for link in links:
            text = text.replace(link[0], ', ')    
        return text

    def strip_all_entities(self, text):
        """ Removes rrss hastags and mentions from text
        
        Parameters
        -----------
        text: String to remove hastags  
        return: cleaned text      
        
        """

        entity_prefixes = ['@','#']
        for separator in  string.punctuation:
            if separator not in entity_prefixes :
                text = text.replace(separator,' ')
        words = []
        for word in text.split():
            word = word.strip()
            if word:
                if word[0] not in entity_prefixes:
                    words.append(word)
        return ' '.join(words)


    def get_first_text(self, obj):
        
        """Extracts from abn objet:
        - first occurrence if array
        - text if string

        Parameters
        -----------
        obj: object to extract text (array or str)
        return: first ocurrence
       
        """
        
        if (isinstance(obj, list)):
            if(isinstance(obj[0], list)):
                obj[0][0].strip()
            
            else:   
                return obj[0].strip()
        else:
            return obj.strip()