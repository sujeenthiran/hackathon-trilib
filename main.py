import requests
import json

# Faites une requête GET vers l'API
url = "https://opendata.paris.fr/api/explore/v2.1/catalog/datasets/dechets-menagers-points-dapport-volontaire-stations-trilib/records?limit=100"
response = requests.get(url)

# Vérifiez si la requête a réussi
if response.status_code == 200:
    data = response.json()

    # Initialisez une liste pour stocker les coordonnées
    coordinates = []

    # Parcourez les enregistrements pour extraire les coordonnées
    for record in data.get("results", []):
        lon = record["longitude"]
        lat = record["latitude"]
        adresse = record["adresse"]
        code_postal = record["code_postal"]
        coordinates.append({
            "lon": lon,
            "lat": lat,
            "adresse" : adresse + " " + code_postal
        })

    # Écrivez les coordonnées dans un fichier JSON
    with open("coordinates.json", "w") as json_file:
        json.dump(coordinates, json_file)

else:
    print("La requête a échoué avec le code d'état :", response.status_code)
