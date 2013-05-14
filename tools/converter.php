<?php

/**
 * SublimeTextSnippetsConverter
 *
 */
class SublimeTextSnippetsConverter {

    const sublimeSnippetsFolder = '../build/laravel4-snippets/Snippets/*.sublime-snippet';
    const snipMateSnippetsFolder = '../snippets';
    const UltiSnipsSnippetsFolder = '../UltiSnips';

    /**
     * toSnipMate
     *
     * @return void
     */
    static public function toSnipMate()
    {
        $snipMateSnippets = '';

        foreach (glob(self::sublimeSnippetsFolder) as $filename) {
            $doc = new DOMDocument();
            $doc->load($filename);
            $snippets = $doc->getElementsByTagName("snippet");
            foreach ($snippets as $snippet)
            {
                $tabTrigger = $snippet->getElementsByTagName("tabTrigger")->item(0)->nodeValue;
                $content = $snippet->getElementsByTagName('content')->item(0)->nodeValue;
                $description = $snippet->getElementsByTagName('description');
                if($description->length == 0)
                    $description = '';
                else
                    $description = $description->item(0)->nodeValue;
                $snipMateSnippets .= "snippet $tabTrigger";
                $snipMateSnippets .= !empty($description) ? " # $description\n" : "\n";
                $lines = explode("\n", $content);
                for($i = 0; $i < count($lines); $i++)
                {
                    $lines[$i] = str_replace('\$','$',$lines[$i]);
                    $lines[$i] = "\t".$lines[$i];
                }
                $content = implode("\n", $lines);
                $snipMateSnippets .= "$content\n\n";
            }
        }
        file_put_contents(self::snipMateSnippetsFolder.'/'.'laravel.snippets', $snipMateSnippets);
    }

    /**
     * toUltiSnips
     *
     * @return void
     */
    static public function toUltiSnips()
    {
        $UtilSnipsSnippets = '';

        foreach (glob(self::sublimeSnippetsFolder) as $filename) {
            $doc = new DOMDocument();
            $doc->load($filename);
            $snippets = $doc->getElementsByTagName("snippet");
            foreach ($snippets as $snippet)
            {
                $tabTrigger = $snippet->getElementsByTagName("tabTrigger")->item(0)->nodeValue;
                $content = $snippet->getElementsByTagName('content')->item(0)->nodeValue;
                $description = $snippet->getElementsByTagName('description');
                if($description->length == 0)
                    $description = '';
                else
                    $description = $description->item(0)->nodeValue;
                $UtilSnipsSnippets .= "snippet $tabTrigger";
                $UtilSnipsSnippets .= !empty($description) ? " \"$description\"\n" : "\n";
                $lines = explode("\n", $content);
                for($i = 0; $i < count($lines); $i++)
                {
                    $lines[$i] = str_replace('\$','$',$lines[$i]);
                    $lines[$i] = "\t".$lines[$i];
                }
                $content = implode("\n", $lines);
                $UtilSnipsSnippets .= "$content\n";
                $UtilSnipsSnippets .= "endsnippet\n\n";
            }
        }
        file_put_contents(self::UltiSnipsSnippetsFolder.'/'.'laravel.snippets', $UtilSnipsSnippets);
    }
}

SublimeTextSnippetsConverter::toSnipMate();
SublimeTextSnippetsConverter::toUltiSnips();
