NLP_Wuwana script objetive is to apply NLP techniques in order to extract Tags (topics) from  companies descriptions . 

# Installation

In order to use the script there must be installed:

- Python 3.7

and launch the following command to install all the libraries required:

- pip install -r requirements.txt

Once everything is installed, it is necessary to download a Spacy pretrained model in the desired folder.

- python -m spacy download en_core_web_lg

This model can be switched with some other english one from https://spacy.io/models/en


# Config

There is a config file that defines general aspects of the script:

- max_words = 5 # Max number of words/tags to be returned by default. Gensims is limited to 3 by default.
- lib = "wordcloud" # NLP library to be used (wordcloud or gensim).
- desc_field = "description" # field from company table where description text is taken.
- weight_field = "NLPInfoTag" # Field in company table where weights will be stored.
- remove_words = "./data/words_to_remove.txt" # path to file of words to be removed.        
- replace_words = "./data/words_to_replace.txt" # replace_words: path to file of words to be replaced.
- languages = ["es","fr","zh-cn"] # list of languages to be translated, apart from english. Same order is followed in output.
- spacy_model = "./en_core_web_lg" # spacy pretrained model.


# USE

Once defined properly the config file, we can launch the script from a command line this way:

- python main.py --onlyid ID

being ID the Id of the company table we want to update. This command will launch script which will take description text
from desc_field column (in company table), will extract main topics (including weights), for them. Those topics will be stored
in the following table/fields:

- Table Tag: This table that have tags ID and descriptions is updated with all new tags discovered.
- Table Company: For the id selected, 4 columns will be updated: FirstTagID (main tag), SecondTagID (second main tag), OtherTags (rest of them) and NLPInfoTag (or other field selected uin config file, with the 
weights returned by NLP algos). 






