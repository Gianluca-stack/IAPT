from __future__ import unicode_literals, print_function
from spacy.training import Example
import plac
import random
from pathlib import Path
import spacy
from tqdm import tqdm

# Training Data
TRAIN_DATA = [
    ("Malta’s capital Valletta is a fortified city located on a hilly peninsula between two of the finest natural harbours in the Mediterranean. The Siege of Malta in 1565 captured the European imagination and mobilised the resources needed to create the new city of Valletta, founded soon after, in 1566. The Knights of St John, aided by the most respected European military engineers of the 16th century, conceived and planned the city as a single, holistic creation of the late Renaissance, with a uniform grid plan within fortified and bastioned city walls. Since its creation, the city has witnessed a number of rebuilding projects, yet those have not compromised the harmony between the dramatic topography and the Hippodamian grid. The fabric of the city includes a compact ensemble of 320 monuments that encapsulate every aspect of the civil, religious, artistic and military functions of its illustrious founders. These include the 16th century buildings relating to the founding of the Renaissance city, such as the cathedral of St John, the Palace of the Grand Master, the Auberge de Castile et Léon, the Auberge de Provence, the Auberge d’Italie, the Auberge d’Aragon and the Infirmary of the Order and the churches of Our Lady of Victory, St Catherine and il Gesù, as well as the improvements attributed to the military engineers and architects of the 18th century such as the Auberge de Bavière, the Church of the Shipwreck of St Paul, the Library and the Manoel Theatre.", {"entities": [(0, 5, "GPE"), (16, 24, "GPE") ,(152, 157, "GPE"), (261, 269, "GPE")]}),

    ("Malta, island country located in the central Mediterranean Sea.", {"entities": [(0, 5, "GPE")]}),

    ("Mdina a place of peace situated next to Rabat.", {"entities": [(0, 5, "GPE"), (40, 45, "GPE"), (261, 269, "GPE")]}),

    ("Whether it’s day or night, the resort town of Sliema thrums with activity. Historic cathedrals, watchtowers, and forts spatter the area, while along the waterfront locals shop, dine, bar hop, or stroll along the promenade for views of the shimmering Mediterranean.", {"entities": [(46, 52, "GPE")]}),

    ("The small and picturesque fishing village of Marsaxlokk (pronounced marsa-schlock – meaning southeastern port) is located in the South-Eastern part of Malta, adjacent to Żejtun,  Marsaskala and Birżebbuġa.", {"entities": [(45, 55, "GPE")]}),

    ("The Maltese archipelago consists of three islands: Malta, Gozo and Comino, as well as countless megaliths, medieval dungeons and atmospheric towns and villages.", {"entities": [(51, 56, "GPE"), (58, 62, "GPE"), (67, 73, "GPE")]}),

    ("Birgu, also known as Vittoriosa, is an old fortified city on the south side of the Grand Harbour in the South Eastern Region of Malta.", {"entities": [(0, 5, "GPE"), (17, 27, "GPE"), (116, 121, "GPE")]}),

    ("Cospicua is one of the Three Cities in the South Eastern Region of Malta.", {"entities": [(0, 8, "GPE"), (67, 72, "GPE")]}),

    ("Senglea, also known by its title Città Invicta, is a fortified city in the South Eastern Region of Malta. It is one of the Three Cities in the Grand Harbour area, the other two being Cospicua and Birgu, and has a population of approximately 2,720 people.", {"entities": [(0, 7, "GPE"), (17, 27, "GPE"), (116, 121, "GPE"), (152, 157, "GPE"), (261, 269, "GPE")]}),

    ("Gżira is a town in the Central Region of Malta. It is located between Msida and Sliema, also bordering on Ta' Xbiex. It has a population of 8,029 as of March 2014. The word Gżira means island in Maltese, and the town is named after Manoel Island which lies just adjacent to the town." , {"entities": [(0, 5, "GPE"), (40, 46, "GPE"), (70, 75, "GPE"), (80, 86, "GPE"), (106, 115, "GPE"), (173, 178, "GPE")]}),

    ("St. Julian’s is a seaside town in Malta. It’s known for beaches like Balluta Bay, a rocky stretch with a promenade and restaurants. Bars and nightclubs line the streets of Paceville, an area south of St. George’s Bay Beach. Gżira, Pembroke, San Ġwann, Sliema and Swieqi are all within the borders of St. Julian's", {"entities": [(0, 12, "GPE"), (34, 39, "GPE"), (172, 181, "GPE"), (224, 229, "GPE"), (241, 250, "GPE"), (252, 258, "GPE"), (263, 269, "GPE"), (300, 312, "GPE")]}),

    ("Victoria (also known as Rabat, Gozo) is the capital of Gozo Island, in Malta. It’s known for its medieval Citadel, with fortified walls. Within the Citadel, the Gran Castello Historic House is a folklore museum. Gozo Museum of Archaeology has prehistoric stone sculptures. Gozo Cathedral, with a richly painted ceiling, dates to the baroque era. Walls at the 16th-century Old Prison are covered in etchings by former inmates.", {"entities": [(0, 8, "GPE"), (24, 35, "GPE"), (55, 59, "GPE"), (261, 269, "GPE")]}),

]

model = None
output_dir = Path("NER_model")
n_iter = 100

# load model

if model is not None:
    nlp = spacy.load(model)
    print("Loaded model '%s'" % model)
else:
    nlp = spacy.blank("en")
    print("Created blank 'en' model")

# set up the pipeline

if "ner" not in nlp.pipe_names:
    ner = nlp.create_pipe("ner")
    nlp.add_pipe("ner", last=True)
else:
    ner = nlp.get_pipe("ner")

for _, annotations in TRAIN_DATA:
    for ent in annotations.get("entities"):
        ner.add_label(ent[2])

# get names of other pipes to disable them during training

other_pipes = [pipe for pipe in nlp.pipe_names if pipe != "ner"]

# only train NER

with nlp.disable_pipes(*other_pipes):  # only train NER
    optimizer = nlp.begin_training()
    for itn in range(n_iter):
        random.shuffle(TRAIN_DATA)
        losses = {}
        examples = []
        for text, annotation in TRAIN_DATA:
             examples.append(Example.from_dict(nlp.make_doc(text), annotation))
        nlp.update(examples, drop=0.5, losses=losses)

locations = []

# test the ner pipeline on new text
doc = nlp("Malta is a small island nation located in the Mediterranean Sea, and despite its size, it boasts a rich history and a diverse cultural heritage. Its cities are among the most enchanting in Europe, with each offering its own unique blend of history, culture, and tradition. In this essay, we will explore some of the most captivating cities in Malta. Valletta is the capital city of Malta and one of the most iconic cities in the Mediterranean. The city was founded in the 16th century by the Order of Saint John, and it was designed as a fortress city to defend the island from the Ottoman Empire. Today, Valletta is a UNESCO World Heritage Site, and it is known for its magnificent Baroque architecture, stunning landmarks, and vibrant cultural scene. One of the most iconic landmarks in Valletta is St. John's Co-Cathedral, a stunning Baroque church that was built in the 16th century. The cathedral is known for its opulent interior, which is decorated with intricate frescoes, sculptures, and paintings by some of the most renowned artists of the time. Another must-see attraction in Valletta is the Grandmaster's Palace, which served as the residence of the Grandmaster of the Order of St. John. Today, the palace houses the office of the President of Malta, and visitors can explore its opulent interior and admire its impressive collection of artwork and artifacts. Another charming city in Malta is Mdina, also known as the silent city. Mdina is a medieval walled city that was built in the 8th century BC, and it is one of the most well-preserved ancient cities in Europe. The city is known for its narrow streets, stunning architecture, and breathtaking views of the Maltese countryside. One of the most popular attractions in Mdina is the Cathedral of St. Paul, a stunning Baroque cathedral that was built in the 17th century. The cathedral is known for its stunning interior, which features intricate frescoes, sculptures, and paintings. Another must-see attraction in Mdina is the Palazzo Falson, a medieval palace that has been transformed into a museum of art and history. Visitors can explore the palace's opulent interior and admire its impressive collection of art and artifacts. Sliema is another charming city in Malta that is known for its stunning architecture, vibrant cultural scene, and beautiful coastline. The city is a popular destination for tourists, and it offers a wide range of activities and attractions for visitors of all ages. One of the most popular attractions in Sliema is the Promenade, a stunning waterfront walkway that offers breathtaking views of the Mediterranean Sea. Visitors can stroll along the Promenade and admire the city's stunning architecture, or they can relax in one of the many cafes and restaurants that line the waterfront. Another must-see attraction in Sliema is the Stella Maris Church, a stunning Baroque church that was built in the 19th century. The church is known for its opulent interior, which features intricate frescoes, sculptures, and paintings. Finally, we have Rabat, a charming city that is located just outside the walls of Mdina. Rabat is known for its stunning architecture, rich history, and vibrant cultural scene, and it is a popular destination for tourists who want to experience the beauty and charm of rural Malta. One of the most popular attractions in Rabat is the Domus Romana, a stunning Roman villa that was built in the 1st century AD. The villa was rediscovered in the early 20th century, and today it is open to the public as a museum of Roman art and history. Another must-see attraction in Rabat is the Catacombs of St. Paul and St. Agatha,")

for ent in doc.ents:
    if ent.text in locations:
        continue
    else:
        locations.append(ent.text)
        print(ent.text, ent.label_)