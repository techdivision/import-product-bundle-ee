# AGENTS.md - import-product-bundle-ee

## Zweck & Verantwortung

Das `import-product-bundle-ee` Modul bietet **EE-spezifische Bundle Product Import-Funktionalität** mit Staging und Scheduling-Support. Es ist ein **Tier 6 Modul** in der EE-Import-Hierarchie und erweitert das `import-product-bundle` Modul mit Enterprise Edition Features.

**Hauptverantwortung:**
- EE Bundle Product Staging Support (zukünftige Bundle-Updates)
- EE Sequence Actions für Audit-Trail Bundle-Imports
- Repository Pattern für EE Bundle-spezifische Daten
- Observer Pattern für EE-Integration Hooks
- Staging-Table Management (catalog_bundle_*_staging)
- Version und Timeline Management für Bundles

**Modul-Kategorie:** EE Extension Module  
**Komplexität:** ⭐⭐⭐⭐ (Hoch - Staging-Logik)  
**Abhängig von:** Magento EE Enterprise Edition

## Architektur & Design Patterns

### Kern-Klassen
- **EeBundleRepository**: EE Bundle-spezifische Persistierung mit Staging
- **StagingBundleRepository**: Staging-Table Management
- **SequenceActionRepository**: Audit-Trail für Bundle-Imports
- **EeBundleProcessor**: Service Layer für EE Bundle-Verarbeitung
- **EeBundleObserver**: Observer für EE Lifecycle Hooks
- **BundleStagingManager**: Koordiniert Staging Updates

### Verwendete Patterns
- **Observer Pattern**: Integration mit Parent Bundle Import Hooks
- **Repository Pattern**: Abstraktion der Staging-Datenschicht
- **Service Layer Pattern**: EE-spezifische Business Logic
- **Staging Pattern**: Zeitgesteuerte Updates
- **Decorator Pattern**: Erweiterung der Base Bundle Repositories

### Staging-Datenfluss
```
Bundle CSV (mit Datum/Zeit)
    ↓
Parser + Converter
    ↓
EE Bundle Processor
    ├─→ StagingBundleRepository (in staging-Tabellen)
    ├─→ SequenceActionRepository (Audit-Trail)
    └─→ BundleStagingManager (Timing-Verwaltung)
    ↓
Magento Database (catalog_bundle_*_staging)
    ↓
Scheduler aktualisiert Produktivtabellen zum Zeitstempel
```

## Abhängigkeiten

### Externe Pakete
- **Keine direkten PHP-Pakete**

### TechDivision Dependencies
- **import-product-ee** ^27.2 - EE Product Importer (Base)
- **import-product-bundle** ^26.1 - Bundle Product Importer (Parent)
- **import-converter-ee** - EE Conversion Framework
- **import-product-ee** - EE Product Extensions

### Abhängig von diesem Modul (1 Reverse Dependency)
- **import-cli-simple** - Master CLI für alle Importer

### Magento EE Dependencies
- **Magento_Staging** - Core Staging Framework
- **Magento_Enterprise** - EE License Check

## Wichtige Entry Points

### Repository Klassen
```php
// EE Bundle Repository - mit Staging-Support
EeBundleRepository::create($row): void
EeBundleRepository::findByProductIdAndStaging($productId, $stagingId): BundleStaging

// Staging Bundle Repository - Staging-Tabellen-Verwaltung
StagingBundleRepository::create($row, $stagingData): void
StagingBundleRepository::findByStagingId($stagingId): array

// Sequence Action Repository - Audit-Trail
SequenceActionRepository::createAction($bundleId, $action): void
```

### Service Methods
- `EeBundleProcessor::process()` - Haupteingangspunkt mit Staging
- `BundleStagingManager::schedule()` - Plant Staging-Update
- `BundleStagingManager::validateSchedule()` - Prüft Timing

## Events & Extension Points

**Erbt Parent Events** aus import-product-bundle, erweitert um EE-spezifische

### Observer Hooks
- `product.import.bundle.staging.validate.pre` - Vor Staging-Validierung
- `product.import.bundle.staging.process.post` - Nach Staging-Verarbeitung
- `product.import.bundle.sequence.action.create` - Audit-Trail Record
- `product.import.bundle.staging.schedule.post` - Nach Scheduling

## Database Schema

### EE-Staging-Tabellen
- **catalog_bundle_product_staging** - Bundle Staging (wie catalog_bundle_product)
  - `entity_id`, `product_id`, `sku_type`, `weight_type`
  - `created_in`, `updated_in` - Staging Timeline
  
- **catalog_bundle_option_staging** - Option Staging
  - `option_id`, `parent_id`, `title`, `type`
  - `created_in`, `updated_in` - Staging Timeline

- **catalog_bundle_selection_staging** - Selection Staging
  - `selection_id`, `option_id`, `product_id`
  - `created_in`, `updated_in` - Staging Timeline

### Audit-Trail Tabellen
- **sequence_product_ee** - Sequence für Bundle Imports
  - `sequence_id`, `bundle_id`, `action_type`
  - `created_at`, `import_batch_id`

## Common Use Cases

### Use Case 1: Zukünftiges Bundle-Update mit Staging
```php
// CSV mit Staging-Datum:
// sku,bundle_option_title,bundle_option_type,bundle_selection_sku,staging_from_date

// BUNDLE-001,Geschenk,radio,GIFT-001,2026-04-15 10:00:00
// BUNDLE-001,Geschenk,radio,GIFT-002,2026-04-15 10:00:00

// Importer erstellt:
// 1. Bundle in catalog_bundle_*_staging Tabellen
// 2. created_in/updated_in = 2026-04-15 10:00:00
// 3. Scheduler aktiviert zum Zeitstempel
```

### Use Case 2: Audit-Trail für Compliance
```php
// Nach Bundle-Import wird Audit-Log erstellt
// sequence_product_ee Eintrag:
// - bundle_id: 123
// - action_type: 'CREATE'
// - import_batch_id: 'BUNDLE_2026_04_15'
```

## Performance Considerations

### Wichtige Performance-Aspekte
1. **Staging-Overhead**: Schreib in 3x so viele Zeilen (live + staging + versions)
2. **Timeline Indizes**: created_in/updated_in MUSS indexiert sein
3. **Sequence-Lookups**: Audit-Trail Inserts sollten batched werden
4. **Versioning-Kosten**: Alte Versions müssen gereinigt werden

### Optimierungen
- Batch Staging-Inserts (max 500 pro Batch)
- Nutze Transaktionen für Consistency zwischen live/staging
- Cleanup alte Staging-Daten nach Schedule-Execution
- Cache Staging-IDs und Timeline-Daten

### Speicher-Optimierung
- Streame große Staging-Operationen
- Garbage Collection für Audit-Trail Records
- Archiviere alte Sequence-Actions

## Hints für KI-Agenten

### Kritisches Verständnis
1. **Tier 6 Modul**: EE-spezifische Extension des Bundle Importers
2. **Staging-fokussiert**: Arbeitet mit zukünftigen Timelines
3. **Observer Pattern**: Integration in Parent Bundle Import
4. **Audit-Trail**: Sequencing für Compliance/Audit
5. **Timeline-Management**: created_in/updated_in Handling

### Häufige Fehler
- ❌ Staging-Tabellen ignorieren (Daten landen nicht live)
- ❌ Timeline-Indizes nicht beachten (Performance-Problem)
- ❌ Sequence-Action nicht erstellen (keine Audit-Spur)
- ❌ Alte Staging-Daten nicht cleanup
- ❌ Transaktionen nicht nutzen (Datenkonsistenz-Problem)

### Best Practices
- ✅ Nutze Staging-Repositories statt direkter DB-Zugriffe
- ✅ Erstelle Sequence-Actions für Audit-Trails
- ✅ Nutze Transaktionen für Multi-Table Updates
- ✅ Validiere Staging-Termine vor Persistierung
- ✅ Implementiere Cleanup für alte Staging-Daten

## Known Limitations

- **EE-Only**: Funktioniert nur auf Magento EE Deployments
- **Staging-Abhängig**: Erfordert dass Magento_Staging aktiviert ist
- **Timeline-Restriktionen**: created_in muss größer als updated_in sein
- **Performance-Overhead**: 3x Speicherplatz für Staging-Duplikate
- **Keine Rollback**: Staging kann nur über Scheduler zurückgängig gemacht werden

## Related Modules

### Direct Dependencies
- **import-product-bundle** - Base Bundle Product Importer
- **import-product-ee** - EE Product Import Framework

### Related/Companion Modules
- **import-product-grouped-ee** - EE Grouped Product Importer
- **import-product-variant-ee** - EE Configurable Product Importer
- **import-product-ee** - Base EE Product Importer

## Troubleshooting

### Problem: Staging-Updates werden nicht aktiv
**Mögliche Ursachen:**
1. Magento_Staging ist nicht aktiviert
2. Scheduler läuft nicht
3. Timeline falsch konfiguriert

**Lösung:**
- Prüfe dass Magento_Staging in module.xml aktiviert ist
- Prüfe dass Cron-Job für Staging läuft (check cron_schedule)
- Validiere dass created_in Zeitstempel in Zukunft liegt

### Problem: Audit-Trail fehlt
**Mögliche Ursachen:**
1. Sequence-Action Repository nicht registriert
2. DI-Konfiguration falsch

**Lösung:**
- Prüfe dass SequenceActionRepository in di.xml definiert ist
- Validiere dass Audit-Flag gesetzt ist (audit_enabled)

### Problem: Staging-Duplikate entstehen
**Mögliche Ursachen:**
1. Mehrfacher Import ohne Cleanup
2. Alte Staging-Daten nicht gelöscht

**Lösung:**
- Implementiere Cleanup-Cron Job
- Prüfe dass old staging entries gelöscht werden

## Zusammenfassung

`import-product-bundle-ee` ist ein **Tier 6 EE-Modul**, das Enterprise Edition Features für Bundle Product Import bietet. Es baut auf dem Base Bundle Importer auf und fügt Staging, Scheduling und Audit-Trails hinzu.

**Für KI-Agenten:** Verstehe dieses Modul als:
- **EE Bundle Product Importer** mit Staging/Scheduling Support
- **Tier 6 Extension** mit Timeline-Management
- **Staging-fokussiert** mit created_in/updated_in Timeline
- **Audit-Trail Integration** für Compliance und Tracking
