<?php

namespace App\Http\Controllers\Admin;

use App\Exports\NewsletterExport;
use App\Http\Controllers\AppController;
use App\Newsletter;

class NewsletterController extends AppController
{
    protected $class = Newsletter::class;
    protected $viewFolder = 'admin.newsletter';
    protected $needAuthorization = false;

    public function export()
    {
    	return \Excel::download(new NewsletterExport, 'newsletter.xlsx');
    }
}
