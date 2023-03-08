
# Softic Laravel App

This app use for reference commission management.



# Installtion & Server #
```bash
  git clone https://github.com/adilurfaisal/distribution-commission.git
```
- copy .env.example
- rename .env
- open .env
- change mysql connection

### Laravel ( Backend ) ###
```bash
  cd distribution-commission
  composer update
  php artisan migrate:fresh --seed
  php artisan serve
```

### Quasar ( Front-end ) ###
```bash
  cd softic-project
  npm install
  npm run dev
```


### Login  ###

```
Admin
User: admin@gmail.com
Pass: admin
```
```
Affiliate
User: affiliate@gmail.com
Pass: affiliate
```
```
Sub Affiliate
User: subaffiliate@gmail.com
Pass: subaffiliate
```
```
Normal
User: normal@gmail.com
Pass: normal
```
```
Normal Without Commission
User: normalext@gmail.com
Pass: normalext
```