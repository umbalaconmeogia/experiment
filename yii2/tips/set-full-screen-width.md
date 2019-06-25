# Set full screen width

## In views/layout/main.php
Change
```php
<div class="container">
```
by
```php
<?php
		$containerClass = 'container';
		$containerStyle = '';
		if (isset($this->params['fluid']) && $this->params['fluid']) {
				$containerClass = 'container-fluid';
				$containerStyle = 'padding-top: 70px;';
		};
?>
<div class="<?= $containerClass ?>" style="<?= $containerStyle ?>">
```

## In view file that need full screen
Set
```php
$this->params['fluid'] = true;
```