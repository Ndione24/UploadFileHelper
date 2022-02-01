# UploadFileHelper

## Usage example :
```java
$uploadObject = new UtilFileUpload($_FILES['file']);

$uploadObject
    ->generateName()
    ->moveTo("/public/resource_folder/")
    ->acceptedExtensions(["png", "jpg", "jpeg", "pdf"])
    ->sizeLimit(10000000000)
    ->process();
    
 // If error : 
 if (count($uploadObject->getError()) > 0) {
    echo json_encode(array('success' => false, "message" => $uploadObject->getError()), JSON_PRETTY_PRINT);
}

```
