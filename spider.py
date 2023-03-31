import requests
import json
import sys
from bs4 import BeautifulSoup as BS

# 接收變數
num_1 = sys.argv[1]

#url = 'https://www.ptt.cc/bbs/' + Kaohsiung + '/index.html'
url = 'https://www.ptt.cc/bbs/' + num_1 + '/index.html'
bs = BS(requests.get(url).text, "html.parser")
titles = bs.find_all("div", attrs={"class": "title"})

all_title = []
for title in titles:
    title = title.text.strip()
    if (title.find('公告') < 0):
        all_title.append(title)


print(json.dumps(all_title))
