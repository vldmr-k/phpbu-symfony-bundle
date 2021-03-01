# phpbu-symfony

Install bundle into symfony project

```
composer require vldmrk/phpbu-symfony-bundle
```

Add Bundle 
```
Vldmrk\PhpbuBundle\PhpbuBundle::class => ['all' => true],
```

Place configuration file ```phpbu.xml``` into the root of project `'%kernel.project_dir%/phpbu.xml'`


Run backup scenario
`php bin/console phpbu:backup`

## Notice
You can rewrite default location of configuration file for phpbu, 
just change parameter `phpbu.configuration`.

After that, check new configuration path `php bin/console debug:container --parameter=phpbu.configuration`
