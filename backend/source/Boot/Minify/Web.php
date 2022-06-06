<?php
if (containsString(url(), "localhost") OR containsString(url(), "127.0.0.1")) {
    //css
    minify(
        __DIR__ . "/../../../../themes/" . CONF_VIEW_THEME . "/assets/styles/",
        [
            __DIR__ . "/../../../shared/styles/styles.css"
        ],
        "css",
        "styles"
    );

    //js
    minify(
        __DIR__ . "/../../../../themes/" . CONF_VIEW_THEME . "/assets/scripts/",
        [
            __DIR__ . "/../../../shared/scripts/scripts.js"
        ],
        "js",
        "scripts"
    );
}

function minify(string $targetAssetDir, array $filesToMinify, string $cssOrJs, string $minifiedFilePrefixName){
    $dir = dir($targetAssetDir);

    if($cssOrJs == "css"){
        $minifier = new MatthiasMullie\Minify\CSS();
    }
    elseif ($cssOrJs == "js"){
        $minifier = new MatthiasMullie\Minify\CSS();
    }
    else{
        return false;
    }

    foreach ($filesToMinify as $file){
        $minifier->add($file);
    }

    //Minify CSS
    $fileName = $minifiedFilePrefixName . SCRIPT_VERSION .".{$cssOrJs}";
    $minifier->minify($targetAssetDir . $fileName);

    //Ajust version
    while($file = $dir->read()){
        if (substr($file, $cssOrJs == "css" ? -4 : -3) === ".{$cssOrJs}"){
            if ($file != $fileName){
                unlink($targetAssetDir . $file);
            }
        }
    }

    $dir->close();
}