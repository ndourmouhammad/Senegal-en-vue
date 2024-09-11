# Senegal en vue

## Installation

1. **Cloner le projet**

    ```bash
    git clone Url_du_projet
    ```

2. **Installer les dépendances avec Composer**

    ```bash
    composer install
    ```

3. **Créer le fichier `.env`**

    Copiez le fichier `.env.example` en `.env` et configurez les variables d'environnement nécessaires.

    ```bash
    cp .env.example .env
    ```

4. **Lancer la migration**

    ```bash
    php artisan migrate
    ```