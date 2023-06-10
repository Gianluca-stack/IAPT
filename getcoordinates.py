import requests
import sys
import json

def get_city_coordinates(city):
    # Replace 'YOUR_API_KEY' with your actual Google Maps Geocoding API key
    api_key = 'AIzaSyDBLb1a4yud9V2PiKFXTEI2VYrWv6Yfggg'
    url = f'https://maps.googleapis.com/maps/api/geocode/json?address={city}&key=AIzaSyDBLb1a4yud9V2PiKFXTEI2VYrWv6Yfggg'

    try:
        response = requests.get(url)
        data = response.json()

        if data['status'] == 'OK':
            results = data['results']
            if len(results) > 0:
                location = results[0]['formatted_address']
                geometry = results[0]['geometry']['location']
                coordinates = {
                    'location': location,
                    'latitude': geometry['lat'],
                    'longitude': geometry['lng']
                }
                return coordinates
            else:
                return None
        else:
            return None
    except requests.exceptions.RequestException as e:
        print('Error:', e)
        return None
    

arg1 = sys.argv[1]
coordinates = get_city_coordinates(arg1)
        
if coordinates is not None:
    print(json.dumps(coordinates))

