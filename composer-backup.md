```
{
  "name": "hasan/fancy-lap-dev",
  "description": "WordPress development environment with stubs",
  "type": "project",
  "autoload": {
    "psr-4": {
      "Hasan\\FancyLabDev\\": "src/"
    }
  },
  "authors": [
    {
      "name": "hasankarim18",
      "email": "hallysust@gmail.com"
    }
  ],
  "scripts": {
    "analyse": "phpstan analyse",
    "lint": "phpcs"
  },
  "require": {
    "php": ">=8.0"
  },
  "require-dev": {
    "php-stubs/wordpress-stubs": "^6.8",
    "php-stubs/woocommerce-stubs": "^10.6",
    "php-stubs/acf-pro-stubs": "^6.5",
    "arifpavel/elementor-stubs": "3.1.4.1",
    "phpstan/phpstan": "^1.11",
    "squizlabs/php_codesniffer": "^3.9",
    "phpcompatibility/php-compatibility": "^9.3",
    "php-stubs/woocommerce-subscriptions-stubs": "^8.4"
  },
  "config": {
    "platform": {
      "php": "8.0.0"
    }
  },
  "minimum-stability": "stable",
  "prefer-stable": true
}
```

# .vscode->settings.json

```
{
  "intelephense.environment.includePaths": [
    "${workspaceFolder}/vendor/php-stubs",
    "${workspaceFolder}/vendor/arifpavel",
    "${workspaceFolder}/woocommerce-custom-stubs.php"
  ],

  "intelephense.stubs": [
    "apache",
    "bcmath",
    "Core",
    "curl",
    "date",
    "json",
    "mbstring",
    "openssl",
    "PDO",
    "mysql",
    "sqlite3",
    "Phar",
    "Reflection",
    "session",
    "sockets",
    "standard",
    "superglobals",
    "tokenizer",
    "xml",
    "wordpress"
  ],

  "intelephense.files.associations": ["**/*.php"],

  "intelephense.diagnostics.enable": true,

  "intelephense.inlayHints.parameterNames.enabled": true,
  "intelephense.inlayHints.variableTypes.enabled": true,
  "intelephense.inlayHints.propertyDeclarationTypes.enabled": true,
  "intelephense.inlayHints.functionReturnTypes.enabled": true,

  "editor.inlayHints.enabled": "on",

  "intelephense.telemetry.enabled": false,

  "files.exclude": {
    "**/vendor/**/.git": true,
    "**/node_modules": true
  },

  "search.exclude": {
    "**/node_modules": true,
    "**/vendor": true
  },

  "editor.fontSize": 14,
  "window.zoomLevel": 0.5
}

```
