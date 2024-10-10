#!/usr/bin/env python
# coding: utf-8

# In[ ]:


import requests
from bs4 import BeautifulSoup
import mysql.connector
import datetime
import time  # for rate limiting (optional)


def scrape_journals_uin_walisongo(search_url, indeks_jurnal_id):
    """
    Scrapes the accreditation of journals listed on the SINTA search page
    that are affiliated with UIN Walisongo Semarang.

    Args:
        search_url (str): The URL of the search page on SINTA website.
        indeks_jurnal_id (int): The ID of the journal in the database.

    Returns:
        str: The extracted accreditation (or None if not found).
    """

    response = requests.get(search_url)
    soup = BeautifulSoup(response.content, 'html.parser')

    # Find all journal listings
    journal_listings = soup.find_all('div', class_='list-item row mt-3')

    journals = []
    for listing in journal_listings:
        # Check affiliation location (more generic selector)
        affiliation_element = listing.find('div', class_=lambda class_name: class_name and 'affil-loc' in class_name and 'mt-2' in class_name)
        if affiliation_element and "Walisongo" in affiliation_element.text:
            # Extract journal name
            journal_name_element = listing.find('div', class_='affil-name mb-3')
            if journal_name_element:
                journal_name = journal_name_element.find('a').text.strip()

            # Find accreditation element (enhanced selector)
            accreditation_element = listing.find('span', class_=lambda class_name: class_name and 'num-stat' in class_name and 'accredited' in class_name)
            accreditation = None
            if accreditation_element:
                accreditation = accreditation_element.text.strip().split()[0]

            # Add journal details to dictionary
            journal_info = {
                "accreditation": accreditation
            }
            journals.append(journal_info)
    return journals



def scrape_sinta_value(search_url, indeks_jurnal_id):
    """
    Scrapes the value of the `<stat num>` tag with the text "Sinta 2" from the provided URL.

    Args:
      search_url (str): The URL of the journal profile page on SINTA website.
      indeks_jurnal_id (int): The ID of the journal in the database.

    Returns:
      str: The extracted Sinta value with "Sinta " replaced by "S" (or None if not found).
    """

    response = requests.get(search_url)
    response.raise_for_status()  # Raise an exception for failed requests

    soup = BeautifulSoup(response.content, "html.parser")

    # Find the card containing "Sinta 2" text
    sinta_card = soup.find("div", class_="card bg-card-orange")

    # Extract the text from the `<stat num>` tag within the card (if it exists)
    sinta_value = None
    if sinta_card:
        sinta_value = sinta_card.find("div", class_="stat-num").text

    # Modify Sinta value if found
    if sinta_value:
        sinta_value = sinta_value.split()[1]  # Get the second word (number)
        sinta_value = "S" + sinta_value  # Prepend "S"

    return sinta_value


def scrape_index(search_urls):
    """
    Iterates through a list of search URLs and attempts to scrape journals using
    scrape_journals_uin_walisongo first, then scrape_sinta_value if the first fails.

    Args:
      search_urls (list): A list of URLs to scrape.

    Returns:
      None
    """

    for i, url in enumerate(search_urls):
        print(f"Link no.{i+1}: ", end='')

        # Fetch journal ID using afetchone()
        sql_get_id = "SELECT id_jurnal FROM jurnal WHERE link_indeks = (%s)"
        data = (url,)  # Wrap base_url in a tuple for the query parameter
        cursor.execute(sql_get_id, data)
        indeks_jurnal_id = cursor.fetchone()[0]  # Extract the first column (id_jurnal) from the result

        journals = scrape_journals_uin_walisongo(url, indeks_jurnal_id)
        if journals:
            for journal in journals:
                if journal['accreditation']:
                    # Store accreditation in database
                    sql = "UPDATE jurnal SET indeks_jurnal = %s WHERE id_jurnal = %s"
                    data = (journal['accreditation'], indeks_jurnal_id)  # Use extracted value
                    cursor.execute(sql, data)
                    db.commit()

                    print(f"Accreditation: {journal['accreditation']}", "id: ", indeks_jurnal_id)
        else:
            sinta_value = scrape_sinta_value(url, indeks_jurnal_id)
            if sinta_value:
                # Store Sinta value in database
                sql = "UPDATE jurnal SET indeks_jurnal = %s WHERE id_jurnal = %s"
                data = (sinta_value, indeks_jurnal_id)
                cursor.execute(sql, data)
                db.commit()

                print(f"Sinta value: {sinta_value}", "id: ", indeks_jurnal_id)
            else:
                # Store accreditation in database
                sql = "UPDATE jurnal SET indeks_jurnal = %s WHERE id_jurnal = %s"
                not_found = "Not Found"
                data = (not_found, indeks_jurnal_id)
                cursor.execute(sql, data)
                db.commit()

                print("Index not found.", "id: ", indeks_jurnal_id)

# Connect to database
db = mysql.connector.connect(
    host="localhost",
    username="monito29_admin",
    password="monito29_admin",
    database="monito29_db",
    charset= "utf8"
)

cursor = db.cursor()

# Retrieve search URLs from the database
cursor.execute("SELECT link_indeks FROM jurnal")
search_urls = [x[0] for x in cursor.fetchall()]

# Iterate through search URLs and scrape data
scrape_index(search_urls)

# Close database connection
db.close()

