import pandas as pd
import sys
import urllib.request
import copy
from surprise import Dataset
from surprise import Reader
from surprise import SVD
from collections import defaultdict
from bs4 import BeautifulSoup
from surprise import accuracy

#df = pd.read_json("Electronics_5.json",lines=True)
df = pd.read_json("Musical_Instruments_5.json",lines=True)
df.head()

#pre-processing
#dropping useless columns for fitting
df = df.drop(columns=['helpful', 'reviewText', 'reviewTime', 'reviewerName','summary','unixReviewTime'])
#rearrange the order of columns
df = df[['reviewerID','asin','overall']]
df.head()

#load data to surprise
reader = Reader(rating_scale=(1, 5))
data = Dataset.load_from_df(df, reader)

#get name of product from asin
def get_name(asin):
    url = "https://www.amazon.com/dp/"+asin
    headers = {'User-Agent': 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36'}
    req = urllib.request.Request(url,None, headers)
    try: 
        soup = BeautifulSoup(urllib.request.urlopen(req).read(), 'html.parser')
        span = soup.find("span", id="productTitle")
        return span.text.strip()
    except:
        return get_name(asin)
		
request = urllib.request.urlopen('http://webdev.cse.msu.edu/~duzengze/recommendation/dsb.php')
reviews = request.read().decode("utf-8") 
review_list = reviews.split("|")
del review_list[-1]
new_list = []
for review in review_list:
    new_list.append(review.split(','))
new_list

new_df = pd.DataFrame( new_list, columns = ['reviewerID','asin','overall'])
new_pd = pd.concat([new_df,df])
new_pd.head()


#load data to surprise
reader = Reader(rating_scale=(1, 5))
data = Dataset.load_from_df(new_pd, reader)

#function to save data back to our database

def save_recommend(uid,r):
    #retry 100 times if exception happens
    for i in range(100):
        try:
            urllib.request.urlopen('http://webdev.cse.msu.edu/~duzengze/recommendation/nmsl.php?uid='+uid+'&first='+r[0]+'&second='+r[1]+'&third='+r[2])
            break
        except:
            continue
			
def get_top_n(predictions, n=10):
    '''Return the top-N recommendation for each user from a set of predictions.

    Args:
        predictions(list of Prediction objects): The list of predictions, as
            returned by the test method of an algorithm.
        n(int): The number of recommendation to output for each user. Default
            is 10.

    Returns:
    A dict where keys are user (raw) ids and values are lists of tuples:
        [(raw item id, rating estimation), ...] of size n.
    '''

    # First map the predictions to each user.
    top_n = defaultdict(list)
    for uid, iid, true_r, est, _ in predictions:
        top_n[uid].append((iid, est))

    # Then sort the predictions for each user and retrieve the k highest ones.
    for uid, user_ratings in top_n.items():
        user_ratings.sort(key=lambda x: x[1], reverse=True)
        top_n[uid] = user_ratings[:n]

    return top_n

#train data
trainset = data.build_full_trainset()
algo = SVD()
algo.fit(trainset)

testset = trainset.build_anti_testset()
predictions = algo.test(testset)
acc = accuracy.rmse(predictions, verbose=True)

ids = df.reviewerID.tolist()

top_n = get_top_n(predictions, n=3)

for uid, user_ratings in top_n.items():
    r = [iid for (iid, _) in user_ratings]
    if uid in ids:
        continue
    save_recommend(uid,r)

	
print("Done!")