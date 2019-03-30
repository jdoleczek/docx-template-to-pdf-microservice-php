# DOCX template to PDF - microservice

As in title you can find hier server with endpoint
**/docx/pdf** that might be used for filling templates
written as DOCX files. Rest API description below.

Templats description might be found at
https://github.com/tyz910/docx-templates .

### Stack

* **PHP 7**,
* [**Flight**](http://flightphp.com/),
* **Vagrant**,
* [**docx-templates**](https://github.com/tyz910/docx-templates),
* [**office-converter**](https://github.com/ncjoes/office-converter),
* Vue JS,
* jQuery,
* Bootstrap 3.

### Run
#### OPTION 1: As Node server

    git clone https://github.com/jdoleczek/docx-template-to-pdf-microservice-php.git
    cd docx-template-to-pdf-microservice-php
    composer install
    sudo php -S 0.0.0.0:80 index.php

Then just open http://localhost/ for an example.

For this option **soffice** (LibreOffice) program
is required to be installed.

#### OPTION 2: With Vagrant

    git clone https://github.com/jdoleczek/docx-template-to-pdf-microservice-php.git
    cd docx-template-to-pdf-microservice-php
    vagrant up

Then just open http://192.168.0.201/ for an example.
You may change IP in Vagrant file.

#### Rest API description

There is only one **POST** end-point: **/docx/pdf**
that accepts JSON data in format:

    {
      data: {
        templates: 'data'
      },
      file: '...DOCX file encoded with Base64...'
    }

In return we get also JSON:

    {
      status: 'ok',
      file: '...PDF file encoded with Base64...'
    }

##### Example

    let payload = {
      data: {
        name: 'Jan',
        surname: 'Kowalski'
        title: 'Przezawodnik miesiąca',
      },
      file: ...
    }

    $.ajax({
      url: '/docx/pdf',
      type: 'POST',
      data: JSON.stringify(payload),
      contentType: 'application/json',
    })
      .then(data => {
        console.log(data.file)
      })

