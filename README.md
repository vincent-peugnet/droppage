DropPage
========

DropPage is a little PHP script that allow users to quickly and easily upload files directly on a web server.

Options are :

- password protected upload
- folder by session (this will create a new folder for each connection with a timestamp)
- max file size
- title and description



Installation
------------

1. Simply clone the git repo from github

        git clone https://github.com/vincent-peugnet/droppage

2. Install dependencies

        composer install

3. Edit filename `config.json.sample` to `config.json`.

4. Edit `config.json` to set text and upload options.


Customization
-------------

### Style

Simply rename `custom.css.sample` to `custom.css` and add your style here. This will be added on top of `default.css`.

### Logo

Edit `config.json` and add `"logo": "<your-logo-adress>"`
