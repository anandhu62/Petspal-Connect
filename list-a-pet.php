<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List a Pet - Petspal Connect</title>
    <link rel="stylesheet" href="list-a-pet.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Varela+Round&display=swap" rel="stylesheet">
    <style>
        
        select#breed {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-bottom: 15px;
            font-size: 16px;
        }
        
        .yes-no-select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-bottom: 15px;
            font-size: 16px;
        }
    </style>
</head> 
<body>
    <div class="intro">
        <h1>List Your Pet for Adoption</h1>
        <p>
            In this section, you will be providing information about your pet. Please take the time to complete this section as fully as possible. This information forms the basis for your pet's listing, and you want to be sure you attract the best adopters!
        </p>
        <p>
            Please choose great photos, and upload any useful documents. Please be honest about your pet. PetspalConnect is here to help people responsibly rehome their pets, and we encourage rehomers to be truthful when describing their pets.
        </p>
    </div>

    <div class="photo-container">
        <h2>Photos</h2>
        <p>You can add up to 4 photos (.jpg, .png, .jpeg). For the best results, please upload landscape or square images. This is a bonded pair listing, so please make sure to add photos of both animals.</p>

        <form action="submit_pet.php" method="post" enctype="multipart/form-data">
            <div class="upload-container">
                <input type="file" id="photo1" name="pet-photo1" accept=".jpg, .png, .jpeg">
                <label for="photo1" class="upload-label">Upload Photo 1</label>

                <input type="file" id="photo2" name="pet-photo2" accept=".jpg, .png, .jpeg">
                <label for="photo2" class="upload-label">Upload Photo 2</label>

                <input type="file" id="photo3" name="pet-photo3" accept=".jpg, .png, .jpeg">
                <label for="photo3" class="upload-label">Upload Photo 3</label>

                <input type="file" id="photo4" name="pet-photo4" accept=".jpg, .png, .jpeg">
                <label for="photo4" class="upload-label">Upload Photo 4</label>
            </div>

            <div class="characteristics-container">
                <h2>Characteristics</h2>
                
                <label for="pet-name">Pet's Name</label>
                <input type="text" id="pet-name" name="pet-name" placeholder="Enter your pet's name" required>
            
                <label for="pet-age">Age (years)</label>
                <input type="number" id="pet-age" name="pet-age" min="0" value="0" required>
            
                <label for="pet-size">Size</label>
                <select id="pet-size" name="pet-size" required>
                    <option value="" disabled selected>Select size</option>
                    <option value="small">Small</option>
                    <option value="medium">Medium</option>
                    <option value="large">Large</option>
                </select>
            
                <label for="pet-sex">Sex</label>
                <select id="pet-sex" name="pet-sex" required>
                    <option value="" disabled selected>Select sex</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>

               
                <label for="breed">Pet's Breed</label>
                <select id="breed" name="breed" required>
                    <option value="" disabled selected>Select breed</option>
                    <optgroup label="Dog Breeds">
                        <option value="australian-shepherd">Australian Shepherd</option>
                        <option value="beagle">Beagle</option>
                        <option value="bernese-mountain-dog">Bernese Mountain Dog</option>
                        <option value="border-collie">Border Collie</option>
                        <option value="boxer">Boxer</option>
                        <option value="bulldog">Bulldog</option>
                        <option value="chihuahua">Chihuahua</option>
                        <option value="cocker-spaniel">Cocker Spaniel</option>
                        <option value="dachshund">Dachshund</option>
                        <option value="doberman">Doberman</option>
                        <option value="french-bulldog">French Bulldog</option>
                        <option value="german-shepherd">German Shepherd</option>
                        <option value="golden-retriever">Golden Retriever</option>
                        <option value="great-dane">Great Dane</option>
                        <option value="husky">Husky</option>
                        <option value="labrador-retriever">Labrador Retriever</option>
                        <option value="maltese">Maltese</option>
                        <option value="pomeranian">Pomeranian</option>
                        <option value="poodle">Poodle</option>
                        <option value="pug">Pug</option>
                        <option value="rottweiler">Rottweiler</option>
                        <option value="shih-tzu">Shih Tzu</option>
                        <option value="yorkshire-terrier">Yorkshire Terrier</option>
                        <option value="mixed-breed-dog">Mixed Breed Dog</option>
                        <option value="other-dog">Other Dog Breed</option>
                    </optgroup>
                    <optgroup label="Cat Breeds">
                        <option value="abyssinian">Abyssinian</option>
                        <option value="american-shorthair">American Shorthair</option>
                        <option value="bengal">Bengal</option>
                        <option value="british-shorthair">British Shorthair</option>
                        <option value="devon-rex">Devon Rex</option>
                        <option value="exotic-shorthair">Exotic Shorthair</option>
                        <option value="maine-coon">Maine Coon</option>
                        <option value="norwegian-forest">Norwegian Forest Cat</option>
                        <option value="persian">Persian</option>
                        <option value="ragdoll">Ragdoll</option>
                        <option value="russian-blue">Russian Blue</option>
                        <option value="scottish-fold">Scottish Fold</option>
                        <option value="siamese">Siamese</option>
                        <option value="sphynx">Sphynx</option>
                        <option value="mixed-breed-cat">Mixed Breed Cat</option>
                        <option value="other-cat">Other Cat Breed</option>
                    </optgroup>
                </select>

                <label for="pet-colour">Colours</label>
                <select id="pet-colour" name="pet-colour" required>
                    <option value="" disabled selected>Select color</option>
                    <option value="black">Black</option>
                    <option value="blue">Blue</option>
                    <option value="brown">Brown/Chocolate</option>
                    <option value="cream">Cream/Fawn/Yellow</option>
                    <option value="gold">Gold/Apricot</option>
                    <option value="mixed">Mixed Colour</option>
                    <option value="other">Other</option>
                    <option value="red">Red/Ginger</option>
                    <option value="silver">Silver/Grey</option>
                    <option value="white">White</option>
                </select>
            </div>

           
            <div class="pet-characteristics">
                <h2>Pet Characteristics</h2>
                
                <label for="vaccinated">Vaccinated</label>
                <select id="vaccinated" name="vaccinated" class="yes-no-select" required>
                    <option value="" disabled selected>Select option</option>
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>

                <label for="neutered">Neutered</label>
                <select id="neutered" name="neutered" class="yes-no-select" required>
                    <option value="" disabled selected>Select option</option>
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>

                <label for="good-with-kids">Is Good with Kids</label>
                <select id="good-with-kids" name="good-with-kids" class="yes-no-select" required>
                    <option value="" disabled selected>Select option</option>
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>

                <label for="good-with-dogs">Is Good with Dogs</label>
                <select id="good-with-dogs" name="good-with-dogs" class="yes-no-select" required>
                    <option value="" disabled selected>Select option</option>
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>

                <label for="good-with-cats">Is Good with Cats</label>
                <select id="good-with-cats" name="good-with-cats" class="yes-no-select" required>
                    <option value="" disabled selected>Select option</option>
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>
                <label for="housetrained">House Trained</label>
    <select id="housetrained" name="housetrained" class="yes-no-select" required>
        <option value="" disabled selected>Select option</option>
        <option value="yes">Yes</option>
        <option value="no">No</option>
    </select>

    <label for="microchipped">Microchipped</label>
    <select id="microchipped" name="microchipped" class="yes-no-select" required>
        <option value="" disabled selected>Select option</option>
        <option value="yes">Yes</option>
        <option value="no">No</option>
    </select>

    <label for="purebred">Purebred</label>
    <select id="purebred" name="purebred" class="yes-no-select" required>
        <option value="" disabled selected>Select option</option>
        <option value="yes">Yes</option>
        <option value="no">No</option>
    </select>

    <label for="has-special-needs">Has Special Needs</label>
    <select id="has-special-needs" name="has-special-needs" class="yes-no-select" required>
        <option value="" disabled selected>Select option</option>
        <option value="yes">Yes</option>
        <option value="no">No</option>
    </select>

    <label for="has-behavioural-issues">Has Behavioral Issues</label>
    <select id="has-behavioural-issues" name="has-behavioural-issues" class="yes-no-select" required>
        <option value="" disabled selected>Select option</option>
        <option value="yes">Yes</option>
        <option value="no">No</option>
                </select>
            </div>

            <div class="description-container">
                <h2>Description</h2>
                <label for="pet-description">Pet Description</label>
                <textarea id="pet-description" name="pet-description" rows="4" placeholder="Describe your pet's personality..."></textarea>
            </div>

            

            <div class="buttoncontainer">
                <input type="submit" value="Submit" class="submit-button">
            </div>
        </form>
    </div>
</body>
</html>
