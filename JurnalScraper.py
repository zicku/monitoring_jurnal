#!/usr/bin/env python
# coding: utf-8

# In[ ]:

#FINAL CODE FOR CHECK UPDATE
#jangan lupa ganti balik db koneksi dari localhost ke monito29

#FINAL CODE FOR CHECK UPDATE
#jangan lupa ganti balik db koneksi dari localhost ke monito29

import requests
from bs4 import BeautifulSoup
import mysql.connector
import datetime
from threading import Thread  # for multithreading
import time  # for rate limiting (optional)
import re

start_time = time.time()

def joint_seminar():
    base_url = "https://journal.walisongo.ac.id/index.php/PJIS/issue/archive"
    cursor.execute("INSERT INTO `jurnal` (`id_jurnal`, `nama_jurnal`, `link_jurnal`, `jadwal_terbit`, `archive_jurnal`, `volume_terbaru`, `link_indeks`, `indeks_jurnal`) VALUES ('30', 'Joint International Seminar', 'https://journal.walisongo.ac.id/index.php/PJIS', 'Unknown', 'https://journal.walisongo.ac.id/index.php/PJIS/issue/archive', NULL, 'https://sinta.kemdikbud.go.id/journals/index/?q=Joint+International+Seminar', 'Not Found');")
    db.commit()
    delete_query = """
        DELETE a
        FROM artikel AS a
        INNER JOIN (
            SELECT link_artikel, MIN(id_artikel) AS min_id
            FROM artikel
            GROUP BY link_artikel
        ) AS b ON a.link_artikel = b.link_artikel AND a.id_artikel <> b.min_id
    """
    
    cursor.execute(delete_query)
    db.commit()
        
    page = requests.get(base_url)
    soup = BeautifulSoup(page.content, "html.parser")

    # Find all issue links (assuming they are within anchor tags)
    issue_element = soup.find("div", class_=("issueDescription", "issueDescriptionImage", "issueCoverImage"))
    issue_link = issue_element.find("a")["href"]
    latest_volume = "2015"

    # Update volume_terbaru in jurnal table for the current archive_jurnal
    update_query = """
        UPDATE jurnal
        SET volume_terbaru = %s
        WHERE archive_jurnal = %s
    """
    cursor.execute(update_query, (latest_volume, base_url))
    db.commit()

    print(f"Latest volume for {base_url}: {latest_volume}")  # Confirmation message
    
    archive_jurnal_id = int(30)
    
    try:
        page_article = requests.get(issue_link)
        soup2 = BeautifulSoup(page_article.content, "html.parser")

        # Try scraping from TOC image link first
        toc_image_element = soup2.find("div", id="issueCoverImage")
        if toc_image_element and toc_image_element.find("a", href=True):
            toc_image_link = toc_image_element.find("a")["href"]
            toc_page =requests.get(toc_image_link)
            soup3 = BeautifulSoup(toc_page.content, "html.parser")
        
            # Get current date
            current_date = datetime.date.today()

            # Format the date as YYYY-MM-DD
            formatted_date = current_date.strftime('%Y-%m-%d')
            penulis_artikel = "Unknown"
            artikel_parent = soup3.find_all("div", class_="tocTitle")

            for detail in artikel_parent:
                nama_artikel = (
                    detail.find("a", href=True).text
                    if detail.find("a", href=True)
                    else "Front Matter"
                )
                link_artikel = (
                    detail.find("a", href=True)["href"]
                    if detail.find("a", href=True)
                    else "#"
                )
                
            
            insert_query = """
                INSERT INTO artikel (nama_artikel, asal_artikel, link_artikel, tanggal_terbit, penulis_artikel)
                VALUES (%s, %s, %s, %s, %s)
            """
            cursor.execute(insert_query, (nama_artikel, archive_jurnal_id, link_artikel, formatted_date, penulis_artikel))
            db.commit()

            print(f"{nama_artikel} {archive_jurnal_id} {link_artikel} {formatted_date} {penulis_artikel}")
                
                
            num_articles = len(artikel_parent)
                
            print("")
            print(f"Number of articles in this issue: {num_articles}")
            print("-" * 50)  # Separator between issues

    except requests.exceptions.RequestException as e:
        print(f"Error fetching issue link: {e}")
        pass

def RJPTD():
    base_url = "https://journal.walisongo.ac.id/index.php/rjtpd/issue/archive"
    cursor.execute("INSERT INTO `jurnal` (`id_jurnal`, `nama_jurnal`, `link_jurnal`, `jadwal_terbit`, `archive_jurnal`, `volume_terbaru`, `link_indeks`, `indeks_jurnal`) VALUES ('45', 'Research Journal on Teacher Professional Development', 'https://journal.walisongo.ac.id/index.php/rjtpd', 'Twice a year', 'https://journal.walisongo.ac.id/index.php/rjtpd/issue/archive', NULL, 'https://sinta.kemdikbud.go.id/journals/index/?q=Research+Journal+on+Teacher+Professional+Development', 'Not Found');")
    db.commit()    

    delete_query = """
        DELETE a
        FROM artikel AS a
        INNER JOIN (
            SELECT link_artikel, MIN(id_artikel) AS min_id
            FROM artikel
            GROUP BY link_artikel
        ) AS b ON a.link_artikel = b.link_artikel AND a.id_artikel <> b.min_id
    """
    
    cursor.execute(delete_query)
    db.commit()
    
    # Fetch the current page
    page = requests.get(base_url)
    soup = BeautifulSoup(page.content, "html.parser")

    # Find all issue links (assuming they are within anchor tags)
    issue_element = soup.find("div", style ="clear:left;")
    issue_link = issue_element.find("a")["href"]
    latest_volume = issue_element.find("a").text

    # Update volume_terbaru in jurnal table for the current archive_jurnal
    update_query = """
        UPDATE jurnal
        SET volume_terbaru = %s
        WHERE archive_jurnal = %s
    """
    cursor.execute(update_query, (latest_volume, base_url))
    db.commit()

    print(f"Latest volume for {base_url}: {latest_volume}")  # Confirmation message
    
    archive_jurnal_id = int(45)

    try:
        page_article = requests.get(issue_link)
        soup2 = BeautifulSoup(page_article.content, "html.parser")
        # Fallback: scrape from current issue link
        
        # Get current date
        current_date = datetime.date.today()

        # Format the date as YYYY-MM-DD
        formatted_date = current_date.strftime('%Y-%m-%d')
        
        artikel_parent = soup2.find_all("td", class_="tocArticleTitleAuthors")

        for detail in artikel_parent:
             # Extract article title
            title_element = detail.find("div", class_="tocTitle")
            title_link = title_element.find("a") if title_element else None
            nama_artikel = title_link.text.strip() if title_link else "Front Matter"
            link_artikel = title_link["href"] if title_link else "#"
            
            authors = []
            author_elements = detail.find_all("div", class_="tocAuthors")
            for author_element in author_elements:
                author_text = author_element.text.strip()
                author_name = re.sub(r"\s+", " ", author_text)  # Replace multiple whitespaces with single space
                formatted_author = f"{author_name}."
                authors.append(formatted_author)

            # Combine and format author names
            penulis_artikel = "\n".join(authors)
            
            insert_query = """
                INSERT INTO artikel (nama_artikel, asal_artikel, link_artikel, tanggal_terbit, penulis_artikel)
                VALUES (%s, %s, %s, %s, %s)
            """
            cursor.execute(insert_query, (nama_artikel, archive_jurnal_id, link_artikel, formatted_date, penulis_artikel))
            db.commit()

            print(f"{nama_artikel} {archive_jurnal_id} {link_artikel} {formatted_date} {penulis_artikel}")
            
        num_articles = len(artikel_parent)

        print("")
        print(f"Number of articles in this issue: {num_articles}")
        print("-" * 50)  # Separator between issues

    except requests.exceptions.RequestException as e:
        print(f"Error fetching issue link: {e}")
        pass

def scrape_issue(issue_link, archive_jurnal_id):
    try:
        page_article = requests.get(issue_link)
        soup2 = BeautifulSoup(page_article.content, "html.parser")

        # Try scraping from TOC image link first
        toc_image_element = soup2.find("div", id="issueCoverImage", class_="col-sm-3")
        if toc_image_element and toc_image_element.find("a", href=True):
            toc_image_link = toc_image_element.find("a")["href"]

            # Combine requests for fetching articles and TOC details
            toc_page_response = requests.get(toc_image_link)
            soup3 = BeautifulSoup(toc_page_response.content, "html.parser")

            tanggal_terbit = soup3.find("div", class_="infoissue").text.replace(
                " Published: ", ""
            )
            
            date = datetime.datetime.strptime(tanggal_terbit, '%Y-%m-%d').date()  # Format date

            artikel_parent = soup3.find_all("td", class_="tocArticleTitleAuthors")
            num_articles = len(artikel_parent)

            for detail in artikel_parent:
                # Extract article title
                title_element = detail.find("div", class_="tocTitle")
                title_link = title_element.find("a") if title_element else None
                nama_artikel = title_link.text.strip() if title_link else "Front Matter"
                link_artikel = title_link["href"] if title_link else "#"
                
                # Extract and format author names (logic remains the same)
                authors = []
                author_elements = detail.find_all("div", id="authorString")
                for author_element in author_elements:
                    author_text = author_element.text.strip()
                    author_name = re.sub(r"\s+", " ", author_text)  # Replace multiple whitespaces with single space
                    formatted_author = f"{author_name}."
                    authors.append(formatted_author)
                    
                # Combine and format author names
                penulis_artikel = "\n".join(authors)
                
                # Insert data into artikel table
                insert_query = """
                    INSERT INTO artikel (nama_artikel, asal_artikel, link_artikel, tanggal_terbit, penulis_artikel)
                    VALUES (%s, %s, %s, %s, %s)
                """
                cursor.execute(insert_query, (nama_artikel, archive_jurnal_id, link_artikel, date,penulis_artikel))
                db.commit()
                print(f"{nama_artikel} {archive_jurnal_id} {link_artikel} {date} {penulis_artikel}")

        else:
            # Fallback: scrape from current issue link
            tanggal_terbit = soup2.find("div", class_="infoissue").text.replace(
                " Published: ", ""
            )
            date = datetime.datetime.strptime(tanggal_terbit, '%Y-%m-%d').date()  # Format date

            artikel_parent = soup2.find_all("td", class_="tocArticleTitleAuthors")
            num_articles = len(artikel_parent)

            for detail in artikel_parent:
                 # Extract article title
                title_element = detail.find("div", class_="tocTitle")
                title_link = title_element.find("a") if title_element else None
                nama_artikel = title_link.text.strip() if title_link else "Front Matter"
                link_artikel = title_link["href"] if title_link else "#"

                authors = []
                author_elements = detail.find_all("div", id="authorString")
                for author_element in author_elements:
                    author_text = author_element.text.strip()
                    author_name = re.sub(r"\s+", " ", author_text)  # Replace multiple whitespaces with single space
                    formatted_author = f"{author_name}."
                    authors.append(formatted_author)


                # Combine and format author names
                penulis_artikel = "\n".join(authors)
                
                # Insert data into artikel table
                insert_query = """
                    INSERT INTO artikel (nama_artikel, asal_artikel, link_artikel, tanggal_terbit, penulis_artikel)
                    VALUES (%s, %s, %s, %s, %s)
                """
                cursor.execute(insert_query, (nama_artikel, archive_jurnal_id, link_artikel, date,penulis_artikel))
                db.commit()
                print(f"{nama_artikel} {archive_jurnal_id} {link_artikel} {date} {penulis_artikel}")

        print("")
        print(f"Number of articles in this issue: {len(artikel_parent)}")
        print("-" * 50)  # Separator between issues

    except requests.exceptions.RequestException as e:
        print(f"Error fetching issue link: {e}")
        pass
        
def Jurnal(archive_links):
    link_number = 1
    for i, base_url in enumerate(archive_links):
        page = requests.get(base_url)
        soup = BeautifulSoup(page.content, "html.parser")

        # Find all issue links (assuming they are within anchor tags)
        issue_element = soup.find("div", class_=("issueDescription", "issueDescriptionImage"))
        if not issue_element:
            print(f"Issue element not found for {base_url}, skipping.")
            continue

        issue_link = issue_element.find("a")["href"]

        # Extract latest volume (assuming it's in the text of the anchor tag)
        latest_volume = issue_element.find("a").text.replace("book ", "")

        # Update volume_terbaru in jurnal table for the current archive_jurnal
        update_query = """
            UPDATE jurnal
            SET volume_terbaru = %s
            WHERE archive_jurnal = %s
        """
        cursor.execute(update_query, (latest_volume, base_url))
        db.commit()

        print(f"Latest volume for {base_url}: {latest_volume}")  # Confirmation message

        # Fetch archive_jurnal_id using afetchone()
        sql_get_id = "SELECT id_jurnal FROM jurnal WHERE archive_jurnal = (%s)"
        data = (base_url,)  # Wrap base_url in a tuple for the query parameter
        cursor.execute(sql_get_id, data)
        archive_jurnal_id = cursor.fetchone()[0]  # Extract the first column (id_jurnal) from the result

        scrape_issue(issue_link, archive_jurnal_id)  # Pass archive_jurnal_id for proper linking

        link_number += 1

# Connect to database
db = mysql.connector.connect(
    host="localhost",
    username="monito29_admin",
    password="monito29_admin",
    database="monito29_db",
    charset= "utf8"
)

cursor = db.cursor()
cursor.execute("DELETE FROM jurnal WHERE archive_jurnal = 'https://journal.walisongo.ac.id/index.php/PJIS/issue/archive'")
cursor.execute("DELETE FROM jurnal WHERE archive_jurnal = 'https://journal.walisongo.ac.id/index.php/rjtpd/issue/archive'")
db.commit()

delete_query = """
    DELETE a
    FROM artikel AS a
    INNER JOIN (
        SELECT link_artikel, MIN(id_artikel) AS min_id
        FROM artikel
        GROUP BY link_artikel
    ) AS b ON a.link_artikel = b.link_artikel AND a.id_artikel <> b.min_id
"""

cursor.execute(delete_query)
db.commit()

cursor.execute("SELECT archive_jurnal FROM jurnal")
archive_links = [x[0] for x in cursor.fetchall()]

Jurnal(archive_links)
joint_seminar()
RJPTD()

delete_query = """
    DELETE a
    FROM artikel AS a
    INNER JOIN (
        SELECT link_artikel, MIN(id_artikel) AS min_id
        FROM artikel
        GROUP BY link_artikel
    ) AS b ON a.link_artikel = b.link_artikel AND a.id_artikel <> b.min_id
"""

cursor.execute(delete_query)
db.commit()

print("Duplicate rows deleted from artikel table.")

# Close database connection
db.close()

end_time = time.time()
execution_time = end_time - start_time
print("Execution time:", execution_time)