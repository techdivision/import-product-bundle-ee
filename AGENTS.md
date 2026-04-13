# AGENTS.md - import-product-bundle-ee

## Zweck & Verantwortung

Das `import-product-bundle-ee` Modul bietet **EE-spezifische Bundle Product Import-Funktionalität**. Es ist ein **Tier 6 Modul** und erweitert `import-product-bundle`.

**Hauptverantwortung:**
- EE Bundle Product Staging Support
- EE Sequence Actions für Bundle Products
- Repository Pattern für EE Bundle-Daten
- Observer Pattern für EE Bundle-Hooks

## Architektur & Design Patterns

### Kern-Klassen
- **EeBundleRepository**: EE Bundle Persistierung
- **StagingBundleRepository**: Staging-Support
- **EeBundleObserver**: Observer für EE-Hooks

### Verwendete Patterns
- **Observer Pattern**: Für EE-Hooks
- **Repository Pattern**: Für Daten-Persistierung

## Abhängigkeiten

### Externe Pakete
- **Keine**

### TechDivision Dependencies
- **import-product-ee** ^27.2 - EE Product Importer
- **import-product-bundle** ^26.1 - Bundle Product Importer

### Abhängig von diesem Modul (1 Reverse Dependency)
- **import-cli-simple** - Master CLI

## Wichtige Entry Points

### Repository Klassen
```php
// EE Bundle Repository
EeBundleRepository::create($row): void

// Staging Bundle Repository
StagingBundleRepository::create($row): void
```

## Events & Extension Points

**Keine Events** - Tier 6 EE-Modul

## Hints für KI-Agenten

### Wichtig zu verstehen
1. **Tier 6 Modul**: Erweitert Bundle Product Importer mit EE-Features
2. **EE-fokussiert**: Spezialisiert auf EE Staging
3. **Observer Pattern**: Für EE-Hooks
4. **Staging Support**: Für EE Staging-Tabellen

## Bekannte Einschränkungen

- **EE-Only**: Nur für Magento EE Deployments
- **Bundle-EE-Only**: Nur für EE Bundle Products

## Zusammenfassung

`import-product-bundle-ee` ist ein **Tier 6 Modul**, das EE-spezifische Bundle Product Import-Funktionalität bietet. Es erweitert den Bundle Product Importer mit EE-Features.

**Für Agenten:** Verstehe dieses Modul als **EE Bundle Product Importer** mit Staging Support.
