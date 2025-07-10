<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Admin - Gestion des images</title>
  <link rel="stylesheet" href="../assets/style.css">
  
  <style>
    /* Style*/
    .admin-image {
      display: flex;
      align-items: center;
      gap: 20px;
      margin-bottom: 20px;
    }
    .admin-image img {
      width: 100px;
      height: 100px;
      object-fit: cover;
      border: 1px solid #ccc;
    }
  </style>
</head>
<body>
  <h1>Administration des images</h1>
  <div id="liste-images"></div>

  <script>
    // Charge les images depuis la BDD
    fetch('../Modele/get_images.php')
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          const container = document.getElementById('liste-images');
          data.images.forEach((img, index) => {
            const div = document.createElement('div');
            div.className = 'admin-image';
            div.innerHTML = `
              <img src="${img.url}" alt="${img.nom}">
              <form onsubmit="return modifierImage(event, ${img.id})">
                <input type="text" name="nom" value="${img.nom}" required>
                <input type="text" name="url" value="${img.url}" required size="50">
                <button type="submit">Modifier</button>
              </form>
            `;
            container.appendChild(div);
          });
        } else {
          alert("Erreur lors du chargement des images.");
        }
      });

    // Envoie les modifications
    function modifierImage(event, id) {
      event.preventDefault();
      const form = event.target;
      const nom = form.nom.value;
      const url = form.url.value;

      fetch('../Modele/update_image.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id, nom, url })
      })
        .then(res => res.json())
        .then(data => {
          if (data.success) {
            alert("Image mise à jour !");
            location.reload();
          } else {
            alert("Erreur : " + data.message);
          }
        });

      return false;
    }
  </script>
</body>
</html>
