<?php
/*
MIT License

Copyright (c) 2012 Luis E. S. Dias - smartbyte.systems@gmail.com

Permission is hereby granted, free of charge, to any person obtaining
a copy of this software and associated documentation files (the
"Software"), to deal in the Software without restriction, including
without limitation the rights to use, copy, modify, merge, publish,
distribute, sublicense, and/or sell copies of the Software, and to
permit persons to whom the Software is furnished to do so, subject to
the following conditions:

The above copyright notice and this permission notice shall be
included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
*/
class PageHolder extends Page {
    
    public static $db = array(
        'Limit' => 'int'
    );
    
    public function populateDefaults() {
        parent::populateDefaults();
        $this->Limit = 10;
    }

    public function getCMSValidator() 
    { 
      return new RequiredFields('Limit'); 
    }
    
    public function getCMSFields() {
        $fields = parent::getCMSFields();
        $fields->addFieldToTab('Root.Content.Main',new NumericField('Limit','Limit ( 0 = all)'),'Content');
        return $fields;
    }
    
}
class PageHolder_Controller extends Page_Controller {
    
    protected $caller_class = 'YourChildClassName';
    
    public function init() {
        parent::init();
    }
    
    public function GetChildren() {
        if(!isset($_GET['start']) || !is_numeric($_GET['start']) || (int)$_GET['start'] < 1) $_GET['start'] = 0;
        $SQL_start = (int)$_GET['start'];
        $callerClass = $this->getCallerClass();
        $filter = "ParentID = '".$this->ID."'";
        $sort = "Created DESC";
        
        $do = DataObject::get(
            $callerClass,
            $filter,
            $sort
        );

        $doSet = new DataObjectSet();
        if ( !is_null($do) > 0) {
            foreach ($do as $item) {
                if ($item->canView()) {
                    $doSet->push($item);
                }
            }            
        }
        
        $doSet4Template = $doSet->getRange((int)$_GET['start'], (int)$this->Limit);
        if ( $this->Limit > 0 ) {
            $doSet4Template->setPageLimits((int)$SQL_start, (int)$this->Limit, $doSet->Count());
        }

        return $doSet4Template ? $doSet4Template : false;
    }

    public function getCallerClass() {
        return $this->caller_class;
    }
    
}