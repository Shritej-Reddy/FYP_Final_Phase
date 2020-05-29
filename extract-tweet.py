import requests
import argparse
import nltk
nltk.download('stopwords')

from bs4 import BeautifulSoup
import numpy as np
import pandas as pd

parser = argparse.ArgumentParser()
parser.add_argument("--url",type=str,help="Link to the tweet")

args = parser.parse_args()


url = u'https://twitter.com/search?q='
query = u'elon musk'
post_query = u'&src=typed_query'
#r = requests.get(url+query+post_query)

#r = requests.get("https://twitter.com/elonmusk/status/1254921827769561089")
#r = requests.get("https://twitter.com/JamesTodaroMD/status/1255142471555616772")
r = requests.get(args.url)
#print(r)

soup = BeautifulSoup(r.text,'html.parser')

tweets = [p.text for p in soup.findAll('p',class_='tweet-text')]
#print(tweets)


# Similarity between tweets and comments

def jaccard_similarity(query, document):
    intersection = set(query).intersection(set(document))
    union = set(query).union(set(document))
    return float(len(intersection)/len(union))

sim_score = np.arange(len(tweets)*len(tweets),dtype = np.float32).reshape(len(tweets),len(tweets))
#print("Similarity Score 1:", sim_score)                               # Initialized similarity

for i in range(len(tweets)):
    for j in range(len(tweets)):
        sim_score[i][j] = jaccard_similarity(tweets[i],tweets[j])

#print("\nSimilarity after jaccard: ",sim_score)

simi_score = pd.DataFrame(columns=['x','y','val'])
#print("\nDataframe: \n",simi_score.head())

for i in range(len(tweets)):
    for j in range(len(tweets)):
        simi_score = simi_score.append({'x':tweets[i],'y':tweets[j],'val':jaccard_similarity(tweets[i],tweets[j])},ignore_index = True)

simi_score = simi_score.pivot(index='x',columns='y',values='val')
#print("\nSimilarity score",simi_score)


"""
# plotting the heatmap

from string import ascii_letters
import numpy as np
import pandas as pd
import seaborn as sns
import matplotlib.pyplot as plt

sns.set(style="white")

mask = np.triu(np.ones_like(simi_score, dtype=np.bool))

# Set up the matplotlib figure
f, ax = plt.subplots(figsize=(11, 9))

# Generate a custom diverging colormap
cmap = sns.diverging_palette(220, 10, as_cmap=True)

# Draw the heatmap with the mask and correct aspect ratio
sns_plot = sns.heatmap(simi_score)

fig = sns_plot.get_figure()
fig.savefig("plot.png")
""" 

# ====== Text summarization ===========

import bs4 as bs
import urllib.request
import re

# ====== For wikipedia data ======
#scraped_data = urllib.request.urlopen('https://en.wikipedia.org/wiki/Artificial_intelligence')
#scraped_data = urllib.request.urlopen(args.url)
#article = scraped_data.read()
# parsed_article = bs.BeautifulSoup(article,'lxml')
# ================================


# ======= For twitter data ======
article = requests.get(args.url)
#print("Article: \n",article)
#article = article1[0]

parsed_article = bs.BeautifulSoup(article.text,'html.parser')
#print("Span\n:", parsed_article.span)

paragraph = [p.text for p in parsed_article.find_all('p')]

paragraphs = paragraph[18:len(paragraph)-2]


#paragraphs = parsed_article.findAll('p')
#paragraphs = parsed_article.findAll('span')
#print(paragraphs)

article_text = ""

#article_text = paragraphs[18]
#article_text = paragraphs
#print("\nArticle Text:", article_text)

#print(p for p in paragraphs[18:len(paragraphs)])

for p in paragraphs:
    article_text += p

# Removing Square Brackets and Extra Spaces
article_text = re.sub(r'\[[0-9]*\]', ' ', article_text)
article_text = re.sub(r'\s+', ' ', article_text)

#print("Article_text:\n",article_text[18:])

sumry = article_text[18:]
print(sumry)

# Removing special characters and digits
formatted_article_text = re.sub('[^a-zA-Z]', ' ', article_text )
formatted_article_text = re.sub(r'\s+', ' ', formatted_article_text)


sentence_list = nltk.sent_tokenize(article_text)

stopwords = nltk.corpus.stopwords.words('english')

word_frequencies = {}
for word in nltk.word_tokenize(formatted_article_text):
    if word not in stopwords:
        if word not in word_frequencies.keys():
            word_frequencies[word] = 1
        else:
            word_frequencies[word] += 1

maximum_frequncy = max(word_frequencies.values())

for word in word_frequencies.keys():
    word_frequencies[word] = (word_frequencies[word]/maximum_frequncy)


## Calculating Sentence Score

sentence_scores = {}
for sent in sentence_list:
    for word in nltk.word_tokenize(sent.lower()):
        if word in word_frequencies.keys():
            if len(sent.split(' ')) < 30:
                if sent not in sentence_scores.keys():
                    sentence_scores[sent] = word_frequencies[word]
                else:
                    sentence_scores[sent] += word_frequencies[word]

# Summary 

import heapq
summary_sentences = heapq.nlargest(7, sentence_scores, key=sentence_scores.get)

summary = ' '.join(summary_sentences)
#print(summary)
