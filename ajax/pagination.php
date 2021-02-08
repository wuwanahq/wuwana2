<?php

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $pageCount = $_POST['pageCount'];

    $locations = WebApp\Data::getLocation()->selectUsefulItemsOnly('es');
    $companies = WebApp\Data::getCompany()->selectCategoriesRegions($language, [], $selectedRegions, 0);
    $companies = array_splice($companies,($pageCount*8),8);
    $counter = count($companies);

    $output = "";

    foreach ($companies as $permalink => $company){
        $output .= '<a class="card" href="/'. $permalink.'">
            <div class="logo-main margin-r16">
                <img src="'. $company->logo.'" alt="">
            </div>
            <div class="company-card-wrapper">
                <div class="company-card-info">
                    <h3>'.$company->name.'</h3>
                    <ul class="tag-area">
                        <li>'.implode('</li><li>', $company->tags).'</li>
                    </ul>
                    <div class="button-icon-small margin-t-auto">
                        <img src="/static/icon/tiny/map.svg" alt="">
                        '. $locations[$company->region].'
                    </div>
                </div>
                <div class="company-card-badge-wrapper"></div>
            </div>
        </a>';
        if (--$counter > 0) { $output .= '<hr>'; }
    }

    echo $output;
}
