<?php

namespace App\PanaceaClasses;

class DocCounter
{
    
    // Class Variables   
    public $doc_counter_file;
    public $filetype;
    
    // Set file
    public function setFile($filename)
    {
        $this->doc_counter_file = $filename;
        $this->filetype = pathinfo($this->doc_counter_file, PATHINFO_EXTENSION);
    }
    
    // Get file
    public function getFile()
    {
        return $this->doc_counter_file;
    }
    
    // Get file information object
    public function getInfo()
    {
        // Function variables
        $ft = $this->filetype;
        
        // Let's construct our info response object
        $obj = new \stdClass();
        $obj->format = $ft;
        $obj->wordCount = null;
        $obj->textLengthCount = null;

        // Let's set our function calls based on filetype
        switch($ft)
        {
            case "doc":
                $doc = $this->read_doc_file();
                $obj->wordCount = $this->str_word_count_utf8($doc);
                $obj->lineCount = $this->lineCount($doc);
                $obj->textLengthCount = $this->textLengthCount($doc);
                break;
            case "docx":
                $obj->wordCount = $this->str_word_count_utf8($this->docx2text());
                $obj->lineCount = $this->lineCount($this->docx2text());
                $obj->textLengthCount = $this->textLengthCount($this->docx2text());
                break;
            case "txt":
                $textContents = file_get_contents($this->doc_counter_file);
                $obj->wordCount = $this->str_word_count_utf8($textContents);
                $obj->textLengthCount = $this->textLengthCount($textContents);
                break;
            default:
                $obj->wordCount = "unsupported file format";
        }
        
        return $obj;
    }
    
    // Convert: Word.doc to Text String
    function read_doc_file() {
        
        $path = getcwd();
        $f = $path."/".$this->doc_counter_file;

         if(file_exists($f))
        {
            if(($fh = fopen($f, 'r')) !== false ) 
            {
               $headers = fread($fh, 0xA00);

               // 1 = (ord(n)*1) ; Document has from 0 to 255 characters
               $n1 = ( ord($headers[0x21C]) - 1 );

               // 1 = ((ord(n)-8)*256) ; Document has from 256 to 63743 characters
               $n2 = ( ( ord($headers[0x21D]) - 8 ) * 256 );

               // 1 = ((ord(n)*256)*256) ; Document has from 63744 to 16775423 characters
               $n3 = ( ( ord($headers[0x21E]) * 256 ) * 256 );

               // 1 = (((ord(n)*256)*256)*256) ; Document has from 16775424 to 4294965504 characters
               $n4 = ( ( ( ord($headers[0x21F]) * 256 ) * 256 ) * 256 );

               // Total length of text in the document
               $textLength = ($n1 + $n2 + $n3 + $n4);

               $extracted_plaintext = fread($fh, $textLength);
                $extracted_plaintext = mb_convert_encoding($extracted_plaintext,'UTF-8');
               // simple print character stream without new lines
               //echo $extracted_plaintext;

               // if you want to see your paragraphs in a new line, do this
               return nl2br($extracted_plaintext);
               // need more spacing after each paragraph use another nl2br
            }
        }
    }
    // Arvind's simple word splitter
    function str_word_count_utf8($str) {
        $str = strip_tags($str);
        $pattern = "#[^(\w|\d|\'|\"|\.|\!|\?|;|,|\\|\/|\-|:|\&|@)]+#";
        $str = trim(preg_replace($pattern, " ", $str));
        return count(explode(" ", $str));
        //return count(preg_split('~[^\p{L}\p{N}\']+~u',$str));
    }
    // Convert: Word.docx to Text String
    function docx2text()
    {
        return $this->readZippedXML($this->doc_counter_file, "word/document.xml");
    }

    function readZippedXML($archiveFile, $dataFile)
    {
        // Create new ZIP archive
        $zip = new \ZipArchive;
        
        // set absolute path
        $path = getcwd();
        $f = $path."/".$archiveFile;

        // Open received archive file
        if (true === $zip->open($f)) {
            // If done, search for the data file in the archive
            if (($index = $zip->locateName($dataFile)) !== false) {
                // If found, read it to the string
                $data = $zip->getFromIndex($index);
                // Close archive file
                $zip->close();
                // Load XML from a string
                // Skip errors and warnings
                $xml = new \DOMDocument();
                $xml->loadXML($data, LIBXML_NOENT | LIBXML_XINCLUDE | LIBXML_NOERROR | LIBXML_NOWARNING);
                
                $xmldata = $xml->saveXML();
                // Newline Replacement
                $xmldata = str_replace("</w:p>", "\r\n", $xmldata);
                // Return data without XML formatting tags
                return strip_tags($xmldata);
            }
            $zip->close();
        }

        // In case of failure return empty string
        return "";
    }
    
    // Convert: Word.doc to Text String
    function read_doc()
    {
        $path = getcwd();
        $f = $path."/".$this->doc_counter_file;
        $fileHandle = fopen($f, "r");
        $line = @fread($fileHandle, filesize($this->doc_counter_file));
        $lines = explode(chr(0x0D),$line);
        $outtext = "";
        foreach($lines as $thisline)
          {
            $pos = strpos($thisline, chr(0x00));
            if (($pos !== FALSE)||(strlen($thisline)==0))
              {
              } else {
                $outtext .= $thisline." ";
              }
          }
        $outtext = preg_replace("/[^a-zA-Z0-9\s\,\.\-\n\r\t@\/\_\(\)]/","",$outtext);
        return $outtext;
    }
    
   
    
    // Line Count: General
    function lineCount($text)
    {
        $lines_arr = preg_split('/\n|\r/',$text);
        $num_newlines = count($lines_arr); 
        return $num_newlines;
    }

    // Total Length Count: General
    function textLengthCount($text)
    {
        $num_newlines = strlen($text);
        return $num_newlines;
    }
}