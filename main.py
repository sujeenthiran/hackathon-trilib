from selenium import webdriver

# Spécifiez le chemin vers le pilote de navigateur (par exemple, ChromeDriver)
driver_path = 'chemin_vers_chromedriver.exe'  # Remplacez par le chemin de votre pilote ChromeDriver
# Initialisez le navigateur Chrome
driver = webdriver.Chrome(executable_path=driver_path)

# L'URL de la page que vous souhaitez scraper
url = "https://www.paris.fr/recherche/lieux?page=3&types=trilib"

# Chargez la page dans le navigateur
driver.get(url)

# Trouvez tous les divs avec la classe "paris-search-hits-item-title"
title_divs = driver.find_elements_by_css_selector('.paris-search-hits-item-title')

# Parcourez les divs et imprimez leur contenu
for title_div in title_divs:
    print(title_div.text)

# Fermez le navigateur
driver.quit()
