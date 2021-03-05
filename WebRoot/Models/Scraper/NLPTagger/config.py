max_words = 5 # max words to be returned by wordcloud. Gensims is limited to 3 by default.
lib = "gensim" # library to be used (wordcloud / gensim).
desc_field = "description" # field from company table where description text is.
weight_field = "NLPInfoTag" # Field in company table where weights will be stored.
remove_words = "./data/words_to_remove.txt" # path to file of words to be removed.        
replace_words = "./data/words_to_replace.txt" # replace_words: path to file of words to be replaced.
languages = ["es","fr","zh-cn"] # list of languages to be translated, in addition to english. Order is followed.
spacy_model = "./en_core_web_lg" # spacy pretrained model.