```blade
<x-mail::message>

# 📚 Bienvenue à SmartLibrary

Bonjour **{{ $data['name'] }}**,  

Nous sommes très heureux de vous accueillir parmi les membres de notre bibliothèque numérique **SmartLibrary** 🎉

Votre inscription a été effectuée avec succès, et votre compte est maintenant actif.  
Vous pouvez dès maintenant consulter notre collection de livres, effectuer des emprunts et profiter de tous nos services en ligne.

---

## 👤 Informations de votre compte

- **Code d'adhérent :** {{ $data['codeA'] }}
- **Adresse :** {{ $data['adresse'] }}
- **Email :** {{ $data['email'] }}

---

## ✨ Ce que vous pouvez faire

📖 Consulter les livres disponibles  
🔎 Rechercher par thème ou auteur  
📚 Emprunter des livres facilement  
🔔 Recevoir des rappels automatiques de retour  

---

<x-mail::button :url="'http://127.0.0.1:8000/livres'">
📚 Explorer la Bibliothèque
</x-mail::button>

Merci pour votre confiance et bonne lecture 📚✨

Cordialement,  
### SmartLibrary Team

</x-mail::message>
```
