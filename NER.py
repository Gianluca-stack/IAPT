import json
import sys
import re
import nltk
from nltk.corpus import stopwords
nltk.download('stopwords')
from nltk.stem import PorterStemmer
nltk.download('punkt')
nltk.download('punkt')
nltk.download('averaged_perceptron_tagger')
nltk.download('maxent_ne_chunker')
nltk.download('words')

def clean_text(text):
    # Remove HTML tags using regular expressions
    clean_text = re.sub('<.*?>', '', text)
    
    # Remove punctuation and special characters
    clean_text = re.sub('[^\w\s]', '', clean_text)
    
    return clean_text

def NER_extraction(text):

    locations = []

    cleaned_text = clean_text(text)
    

    # Step Three: Tokenise, find parts of speech and chunk words 

    for sent in nltk.sent_tokenize(cleaned_text):
        for chunk in nltk.ne_chunk(nltk.pos_tag(nltk.word_tokenize(sent))):
            if hasattr(chunk, 'label'):
                # if GPE is found, store it in the locations list, if it already exists, don't store it
                if chunk.label() == 'GPE' and chunk[0][0] not in locations:
                    locations.append(chunk[0][0])
                    
    
    return locations

arg1 = sys.argv[1]

result = NER_extraction(arg1)
print(json.dumps(result))
            