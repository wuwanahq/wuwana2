# -*- coding: utf-8 -*-
"""
NLP WUWANA MAIN
@author: Oscar Fernández Vicente / ofvicente@gmail.com
jan/21
"""
import sys
import functions
import config
import database_config
import  pymysql
import argparse
import click

def main():

    #args    
    parser = argparse.ArgumentParser(description='WUWANA NLP SCRIPT')
    parser.add_argument("--onlyid")
    args = parser.parse_args()   

    # command line arguments control
    if(args.onlyid):
        if args.onlyid.lower() == 'false':
            if click.confirm('ATENTION: Yo have selected False as onlyid. This will process and replace the tags for every row in company table. Do you want to continue?', default=True):
                pass
            else:
                sys.exit()    
    else:
        sys.exit("--onlyid arg missing. Please, insert one company id")  
            
    if ((str(config.lib) != "gensim") & (str(config.lib) != "wordcloud")):
        print("lib parameter in config.py should be gensim or wordcloud")
        sys.exit()        

    #db connection      
    db = pymysql.connect(host = database_config.server, user = database_config.user, password = database_config.password, database = database_config.database)

    ##MAIN##
        
    nlp_obj = functions.NLP_Wuwana(db, 
                languages=config.languages,
                spacy_model = config.spacy_model,
                max_words=config.max_words, 
                remove_words=config.remove_words,
                replace_words=config.replace_words,
                weight_field=config.weight_field,
                desc_field=config.desc_field )
    nlp_obj.process_query_companies(onlyid = args.onlyid, lib = config.lib.lower())
    #nlp_obj.process_query_companies(onlyid = False, lib = config.lib.lower())


if __name__ == "__main__":
    main()
    
    



