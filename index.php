<?php
use DocxTemplate\TemplateFactory;
use NcJoes\OfficeConverter\OfficeConverter;

require 'vendor/autoload.php';

Flight::route('POST /docx/pdf', function() {
    try {
        $tmp_template = sys_get_temp_dir() . '/' . uniqid() . '.docx';
        $tmp_template_filled = sys_get_temp_dir() . '/' . uniqid() . '.docx';
        $tmp_pdf = sys_get_temp_dir() . '/' . uniqid() . '.pdf';

        file_put_contents($tmp_template, base64_decode(Flight::request()->data->file));

        $template = TemplateFactory::load($tmp_template);
        $template->assign(Flight::request()->data->data);
        $template->save($tmp_template_filled);

        $converter = new OfficeConverter($tmp_template_filled);
        $converter->convertTo(basename($tmp_pdf));
        $pdf = file_get_contents($tmp_pdf);

        @unlink($tmp_template);
        @unlink($tmp_template_filled);
        @unlink($tmp_template);

        Flight::json([
            'status' => 'ok',
            'file' => base64_encode($pdf),
        ]);
    } catch (Exception $_e) {
        Flight::json([
            'status' => 'error',
            'errors' => [
                $_e->getMessage(),
            ],
        ]);
    }
});

Flight::route('/', function(){
    include 'index.html';
});

Flight::start();
