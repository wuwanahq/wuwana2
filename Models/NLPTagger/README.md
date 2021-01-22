NLP_Wuwana script objetive is to apply NLP techniques in order to extract Tags (topics) from  companies descriptions . 

# Installation

In order to use the script there must be installed:

- Python 3.7

and launch the following command to install all the libraries required:

- pip install -r requirements.txt

Once everything is installed, it is necessary to download a Spacy pretrained model in the desired folder.

- python -m spacy download en_core_web_lg


# Config

There is a config file that defines general aspects of the script:

- max_words = 5 # max words to be returned by wordcloud. Gensims is limited to 3 by default.
- lib = "wordcloud" # library to be used (wordcloud / gensim)
- desc_field = "description" # field from company table where description text is
- weight_field = "NLPInfoTag" # Field in company table where weights will be stored.
- remove_words = "./data/words_to_remove.txt" # path to file of words to be removed.        
- replace_words = "./data/words_to_replace.txt" # replace_words: path to file of words to be replaced.
- languages = ["es","fr","zh-cn"] # list of languages to be translated, apart from english. Order is followed.
- spacy_model = "./en_core_web_lg" # spacy pretrained model
