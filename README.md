# php-fatturapa
php-fatturapa is a php implementation for FatturaPA XML specification. 
It allows reading from and writing to files formatted according to the 
specifications described in <LINK> 
<br>

## 1. Installation
To install php-fatturapa, require it using composer:<br>
```
composer require robertogallea/php-fatturapa 
```

## 2. Usage

php-fatturapa currently supports only the Fattura Ordinaria model 
(not Fattura Semplificata)<br>
<br>
The whole DOM of the XML document is wrapped by the class FatturaOrdinaria, 
which could be used directly or build using FatturaPA class.

Follow some basic usage exmaples: 

### 2.1 Read From XML document file
```php
/*   
 * Read from XML
 */
 $filename = 'IT01234567890_FPA01.xml';
 $fattura = FatturaPA::readFromXML($filename); 
```

### 2.2 Read From signed XML file 
```php
/*   
 * Read from XML signed document
 */
 $filename = 'IT01879020517_e4duu.xml.p7m';
 $fattura = FatturaPA::readFromSignedXML($filename); 
```

### 2.3 Read From XML string 
```php
/*   
 * Read from XML string
 */
 $xml = '<your-xml-string>';
 $fattura = FatturaPA::readFromXMLString($xml); 
```

### 2.4 Write to XML file 
```php
/*   
 * Read from XML
 */
 $filename = 'IT01234567890_FPA01.xml';
 FatturaPA::writeToXML($fattura, $filename); 
```

### 2.5 Write to XML string 
```php
/*   
 * Write to XML string
 */
 $xml = FatturaPA::writeToXMLString($fattura); 
```

## 3. Attachment handling
php-fatturapa provides methods for easily add and 
extract attachments to and from the XML document.<br>
By specifications they are stored inside the FatturaElettronicaBody 
element, so the`FatturaElettronicaBody` class provides convenient methods
for storing attachments performing the required compresson and base64 encoding:
```php
/*   
 * Export attachments to folder
 */
 $filename = 'IT01234567890_FPA01.xml';
 $fattura = FatturaPA::readFromXML($filename);
 $folder = '/your/path';  
 
 foreach ($fattura->getFatturaElettronicaBody() as $body);
   $body->esportaAllegati($folder);
 }
```

```php
/*   
 * Add attachment
 */
 $filename = 'IT01234567890_FPA01.xml';
 $fattura = FatturaPA::readFromXML($filename);
 $attachment_filename = /path/to.pdf;
 $attachment = Allegati::createFromFile($attachment_filename,'Name','Description');
 $fattura->getFatturaElettronicaBody()[0]->addAttachment($attachment);
 
```