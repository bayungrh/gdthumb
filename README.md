# gdthumb
Codeigniter library untuk mendapatkan thumbnail/preview file dokumen (pdf,doc) pada Google Drive.

## Instalasi
Copy folder _gdthumb_ ke **"application/libraries/"**

## Contoh Penggunaan
### Memuat library
```php
$this->load->library('gdthumb');
```

### Menyeting Google Developer Key
```php
$this->gdthumb->setGoogleKey('API_KEY_HERE');
```

### Melaukan request
```php
$this->gdthumb->thumbnail('DRIVE_ID');
```

Alternative Parameters
| Parameter | Keterangan |
| --- | --- |
| size | Ukuran yang dihasilkan thumbnail |
| path | Lokasi untuk menyimpan hasil thumbnail |
| filename | Nama file untuk menyimpan hasil thumbnail |

Contoh dengan parameters
```php
$params['size'] = 500; //default 220
$params['path'] = ".downloads/thumbnail/";
$params['name'] = "thumbnail1.png"; //default: [driveid].png
```

## Contoh Code
#### Dengan content-type
```php
header("Content-Type: image/png");
$this->load->library('gdthumb');
$this->gdthumb->setGoogleKey('API_KEY_HERE');
$this->gdthumb->thumbnail('DRIVE_ID_HERE');
```
#### Menyimpan File
```php
$this->load->library('gdthumb');
$this->gdthumb->setGoogleKey('API_KEY_HERE');
$params['size'] = 500;
$params['path'] = "./download/thumbnails/";
$params['name'] = "thumbnail.png"; //default: [driveid].png
$this->gdthumb->thumbnail('DRIVE_ID_HERE', $params);
```

### Google Developer Key
- Kunjungi [Goggle Console](https://console.developers.google.com/)
- Aktifkan Google Drive API pada menu **Library**
- Buat  API Key pada menu **Credentials**