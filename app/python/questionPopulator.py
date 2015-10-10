import logging
import mysql.connector
import random
import praw
import time
import re
from pprint import pprint
from slugify import slugify

class Question:
    title = ""
    answer = ""
    def __init__(self, title, answer):
            self.title = title
            self.answer = answer
    def __eq__(self, other):
            return self.title == other.title
    def __hash__(self):
        return hash(self.title)


logging.basicConfig(filename='test.log',level=logging.DEBUG)

dbh = mysql.connector.connect(user='root',password='mysql',host='127.0.0.1',database='spacexstatsv4')
cursor = dbh.cursor()

# FAQ Pages
pages = ['faq/spacexstats']

# User Agent
user_agent = "SpaceXStatsHelperBot 0.1 by /u/EchoLogic. Grab Wiki content on a daily basis. Currently being tested."
r = praw.Reddit(user_agent=user_agent)

questionset = set()

for page in pages:
	x = r.get_wiki_page('spacex',page)
	# Remove newlines and such
	x.content_md = x.content_md.replace("\r\n","")
	rawquestions = x.content_md.split('###')
	for (i, rawquestion) in enumerate(rawquestions):
		# do not add the page details at the top to the db
		if i != 0:
			rawquestionparts = rawquestion.partition('?')
			q = Question(rawquestionparts[0] + rawquestionparts[1], rawquestionparts[2])
			# check only the question only, ignore the answer!
			if q not in questionset:
				questionset.add(q)

for question in questionset:
    cursor.execute("SELECT COUNT(*) FROM questions WHERE title = %s",(question.title,))
    count = cursor.fetchone()[0]
    #use transactions?
    if count == 1:
        cursor.execute("UPDATE questions SET answer=%s WHERE title=%s",(question.answer,question.title))
    else:
    	cursor.execute("INSERT INTO questions (title, answer, slug) VALUES (%s, %s, %s)", (question.title, question.answer, slugify(question.title)))
    	dbh.commit()

cursor.close()
dbh.close()
