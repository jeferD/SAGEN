import { Component, OnInit, signal, computed, effect } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { ActivatedRoute, Router } from '@angular/router';
import { MockDataService, FacturaRecord } from '../../services/mock-data.service';
import { ReportApiService, ReportFilters } from '../../services/report-api.service';

@Component({
  selector: 'app-query-reports',
  standalone: true,
  imports: [CommonModule, FormsModule],
  template: `
    <div class="query-container animate-fade-in">
      <div class="card">
        <div class="card-title">
          <span><i class="bi bi-file-earmark-spreadsheet-fill"></i> {{ reportTitle() }}</span>
          <span class="badge badge-primary">{{ sectionName() }}</span>
        </div>

        <!-- Search Form -->
        <form (ngSubmit)="onSearch()" #searchForm="ngForm" class="search-form">
          <div class="form-grid">
            <!-- NIT Field (Mostly Required) -->
            <div class="form-group" *ngIf="showNitField()">
              <label class="form-label">NIT del Prestador <span class="required">*</span></label>
              <input 
                type="text" 
                class="form-control" 
                name="txtnit" 
                [(ngModel)]="filters.nit" 
                required 
                placeholder="NIT sin dígito de verificación">
            </div>

            <!-- Cuenta de Cobro Field -->
            <div class="form-group" *ngIf="showCcField()">
              <label class="form-label">Cuenta de Cobro <span *ngIf="isCcRequired()" class="required">*</span></label>
              <input 
                type="text" 
                class="form-control" 
                name="txtctacobro" 
                [(ngModel)]="filters.cuentaCobro" 
                [required]="isCcRequired()"
                placeholder="Nro. Cuenta Cobro">
            </div>

            <!-- Radicado Field -->
            <div class="form-group" *ngIf="showRadicadoField()">
              <label class="form-label">Número de Radicado <span *ngIf="isRadicadoRequired()" class="required">*</span></label>
              <input 
                type="text" 
                class="form-control" 
                name="txtidrad" 
                [(ngModel)]="filters.radicado" 
                [required]="isRadicadoRequired()"
                placeholder="Nro. Radicado">
            </div>

            <!-- Factura Field -->
            <div class="form-group" *ngIf="showFacturaField()">
              <label class="form-label">Número de Factura <span class="required">*</span></label>
              <input 
                type="text" 
                class="form-control" 
                name="txtfactura" 
                [(ngModel)]="filters.factura" 
                required 
                placeholder="Nro. Factura">
            </div>

            <!-- Fecha Inicial (Desde) Field -->
            <div class="form-group" *ngIf="showPeriodoField()">
              <label class="form-label">Fecha Inicial (Desde) <span class="text-optional">(Opcional)</span></label>
              <input 
                type="date" 
                class="form-control" 
                name="txtfini" 
                [(ngModel)]="filters.fechaInicio">
            </div>

            <!-- Fecha Final (Hasta) Field -->
            <div class="form-group" *ngIf="showPeriodoField()">
              <label class="form-label">Fecha Final (Hasta) <span class="text-optional">(Opcional)</span></label>
              <input 
                type="date" 
                class="form-control" 
                name="txtffin" 
                [(ngModel)]="filters.fechaFin">
            </div>

            <!-- Documento Pago Field -->
            <div class="form-group" *ngIf="showDocPagoField()">
              <label class="form-label">Documento de Pago <span class="required">*</span></label>
              <input 
                type="text" 
                class="form-control" 
                name="txtdocto" 
                [(ngModel)]="filters.documentoPago" 
                required 
                placeholder="Nro. Documento Pago">
            </div>
          </div>

          <div class="form-info-note" *ngIf="showPeriodoField()">
            <i class="bi bi-info-circle-fill"></i>
            <span><strong>Filtro de fechas opcional:</strong> Si no ingresa un rango de fechas, se tomará automáticamente desde el <strong>01/01/2014</strong> hasta el día de hoy.</span>
          </div>

          <div class="form-actions">
            <button type="submit" class="btn btn-primary" [disabled]="!searchForm.form.valid || loading()">
              <ng-container *ngIf="loading()">
                <i class="bi bi-arrow-repeat spin"></i> Descargando Insumo...
              </ng-container>
              <ng-container *ngIf="!loading()">
                <i class="bi bi-cloud-arrow-down"></i> CONSULTAR Y DESCARGAR
              </ng-container>
            </button>
            <button type="button" class="btn btn-secondary" (click)="resetForm(searchForm)" [disabled]="loading()">
              <i class="bi bi-arrow-counterclockwise"></i> LIMPIAR
            </button>
          </div>
        </form>
      </div>

      <!-- Download Success Card -->
      <div class="card animate-fade-in download-card" *ngIf="searched() && lastDownload()">
        <div class="download-card-body">
          <div class="download-icon-circle">
            <i class="bi bi-file-earmark-arrow-down-fill"></i>
          </div>
          <div class="download-info">
            <div class="download-header">
              <span class="badge-success"><i class="bi bi-check2-circle"></i> Insumo Descargado</span>
              <span class="download-time">{{ lastDownload()!.timestamp | date:'mediumTime' }}</span>
            </div>
            <h3 class="download-filename">{{ lastDownload()!.fileName }}</h3>
            <div class="download-meta">
              <span class="meta-item"><i class="bi bi-hdd-network"></i> Tamaño: <strong>{{ lastDownload()!.blobSize }}</strong></span>
              <span class="meta-item"><i class="bi bi-table"></i> Registros: <strong>{{ lastDownload()!.recordCount | number }}</strong></span>
              <span class="meta-item" *ngIf="filters.nit"><i class="bi bi-person-badge"></i> NIT: <strong>{{ filters.nit }}</strong></span>
            </div>
          </div>
          <div class="download-actions">
            <button type="button" class="btn btn-primary btn-sm" (click)="onDownloadAgain()">
              <i class="bi bi-arrow-clockwise"></i> Volver a Descargar
            </button>
            <button type="button" class="btn btn-subtle btn-sm" (click)="togglePreview()">
              <i class="bi" [class.bi-eye]="!showPreview()" [class.bi-eye-slash]="showPreview()"></i>
              {{ showPreview() ? 'Ocultar muestra' : 'Ver muestra (' + results().length + ' filas)' }}
            </button>
          </div>
        </div>

        <!-- Optional sample data preview (max 25 rows) -->
        <div *ngIf="showPreview()" class="preview-dropdown animate-fade-in">
          <div class="preview-header">
            <span><i class="bi bi-eye"></i> Muestra de datos (primeros {{ results().length }} registros de {{ lastDownload()!.recordCount | number }})</span>
          </div>
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th *ngFor="let col of activeColumns()">{{ col.header }}</th>
                </tr>
              </thead>
              <tbody>
                <tr *ngFor="let row of results()">
                  <td *ngFor="let col of activeColumns()">
                    {{ getCellValue(row, col) }}
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- No results alert -->
      <div class="card animate-fade-in" *ngIf="searched() && !lastDownload()">
        <div class="no-results">
          <i class="bi bi-search font-lg"></i>
          <p>No se encontraron registros para la consulta especificada con los filtros ingresados.</p>
        </div>
      </div>
    </div>
  `,
  styles: [`
    .query-container {
      display: flex;
      flex-direction: column;
      gap: 20px;
    }

    .search-form {
      display: flex;
      flex-direction: column;
      gap: 16px;
    }

    .card-title-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      width: 100%;
      flex-wrap: wrap;
      gap: 12px;
    }

    .download-card {
      padding: 24px;
      border: 1px solid var(--neutral-200);
      background: #ffffff;
      border-radius: var(--border-radius-lg);
      box-shadow: var(--shadow-sm);
    }

    .download-card-body {
      display: flex;
      align-items: center;
      gap: 20px;
      flex-wrap: wrap;
    }

    .download-icon-circle {
      width: 56px;
      height: 56px;
      border-radius: 50%;
      background: var(--success-light);
      color: var(--success-color);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 28px;
      flex-shrink: 0;
    }

    .download-info {
      flex: 1;
      min-width: 260px;
    }

    .download-header {
      display: flex;
      align-items: center;
      gap: 12px;
      margin-bottom: 6px;
    }

    .badge-success {
      background: var(--success-light);
      color: var(--success-color);
      padding: 3px 10px;
      border-radius: 12px;
      font-size: 0.75rem;
      font-weight: 600;
      display: inline-flex;
      align-items: center;
      gap: 4px;
    }

    .download-time {
      font-size: 0.75rem;
      color: var(--neutral-400);
    }

    .download-filename {
      font-size: 1.1rem;
      font-weight: 700;
      color: var(--neutral-800);
      margin: 0 0 8px 0;
      word-break: break-all;
    }

    .download-meta {
      display: flex;
      gap: 16px;
      flex-wrap: wrap;
      font-size: 0.85rem;
      color: var(--neutral-600);
    }

    .meta-item {
      display: flex;
      align-items: center;
      gap: 6px;
    }

    .download-actions {
      display: flex;
      flex-direction: column;
      gap: 8px;
      align-items: flex-end;
    }

    .preview-dropdown {
      margin-top: 20px;
      padding-top: 16px;
      border-top: 1px dashed var(--neutral-200);
    }

    .preview-header {
      margin-bottom: 12px;
      font-size: 0.875rem;
      font-weight: 600;
      color: var(--neutral-700);
    }

    .btn-subtle {
      background: transparent;
      border: 1px solid var(--neutral-300);
      color: var(--neutral-600);
      padding: 6px 12px;
      border-radius: var(--border-radius-sm);
      cursor: pointer;
      font-size: 0.8rem;
      font-weight: 500;
      display: inline-flex;
      align-items: center;
      gap: 6px;
      transition: all 0.2s ease;
    }

    .btn-subtle:hover {
      background: var(--neutral-100);
      color: var(--neutral-800);
      border-color: var(--neutral-400);
    }

    .text-optional {
      font-size: 0.75rem;
      font-weight: normal;
      color: var(--neutral-500);
      margin-left: 4px;
    }

    .form-info-note {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 10px 16px;
      background-color: var(--primary-light);
      border-left: 4px solid var(--primary-color);
      border-radius: var(--border-radius-sm);
      font-size: 0.825rem;
      color: var(--primary-dark);
      margin-bottom: 8px;
    }

    .form-actions {
      display: flex;
      gap: 12px;
      justify-content: flex-end;
      border-top: 1px solid var(--neutral-200);
      padding-top: 20px;
    }

    .required {
      color: var(--danger-color);
    }

    .no-results {
      text-align: center;
      padding: 40px 20px;
      color: var(--neutral-400);
    }

    .font-lg {
      font-size: 3rem;
      margin-bottom: 12px;
      display: block;
      color: var(--neutral-300);
    }

    .spin {
      display: inline-block;
      animation: spin 1s linear infinite;
    }

    @keyframes spin {
      100% { transform: rotate(360deg); }
    }
  `]
})
export class QueryReportsComponent implements OnInit {
  // Route params state
  section = signal<string>('');
  type = signal<string>('');

  // Search filter inputs
  filters: ReportFilters = {
    nit: '',
    cuentaCobro: '',
    radicado: '',
    factura: '',
    periodo: '',
    documentoPago: '',
    fechaInicio: '',
    fechaFin: ''
  };

  loading = signal<boolean>(false);
  searched = signal<boolean>(false);
  results = signal<any[]>([]);
  dynamicColumns = signal<{ header: string; field: string; format?: (val: any) => string }[]>([]);

  lastBlob: Blob | null = null;
  lastDownload = signal<{
    fileName: string;
    blobSize: string;
    recordCount: number;
    timestamp: Date;
  } | null>(null);
  showPreview = signal<boolean>(false);

  // Pagination State
  currentPage = signal<number>(1);
  pageSize = signal<number>(25);
  pageSizeOptions = [10, 25, 50, 100];

  totalPages = computed(() => {
    const total = Math.ceil(this.results().length / this.pageSize());
    return total > 0 ? total : 1;
  });

  paginatedResults = computed(() => {
    const page = this.currentPage();
    const size = this.pageSize();
    const start = (page - 1) * size;
    return this.results().slice(start, start + size);
  });

  startIndex = computed(() => {
    if (this.results().length === 0) return 0;
    return (this.currentPage() - 1) * this.pageSize() + 1;
  });

  endIndex = computed(() => {
    return Math.min(this.currentPage() * this.pageSize(), this.results().length);
  });

  // Computed values for dynamic templates
  sectionName = computed(() => {
    const sec = this.section();
    return sec.toUpperCase();
  });

  reportTitle = computed(() => {
    const sec = this.section();
    const ty = this.type();

    if (sec === 'recobros') {
      if (ty === 'nit-cuenta') return 'Reporte de Recobros por NIT y Cuenta de Cobro';
      if (ty === 'nit-factura') return 'Reporte de Recobros por NIT y Factura';
      if (ty === 'radicado') return 'Reporte de Recobros por Número de Radicado';
    } else if (sec === 'cartera') {
      if (ty === 'nit-periodo') return 'Reporte de Cartera por NIT y Periodo';
      if (ty === 'nit-cuenta') return 'Reporte de Cartera por NIT y Cuenta de Cobro';
      if (ty === 'lista-radicados') return 'Reporte de Cartera por Lista de Radicados';
    } else if (sec === 'tesoreria') {
      if (ty === 'nit-periodo') return 'Reporte de Pagos por NIT y Periodo';
      if (ty === 'nit-cuenta') return 'Reporte de Pagos por NIT y Cuenta de Cobro';
      if (ty === 'nit-documento') return 'Reporte de Pagos por NIT y Documento de Pago';
      if (ty === 'lista-radicados') return 'Reporte de Pagos por Lista de Radicados';
    } else if (sec === 'impuestos') {
      if (ty === 'nit-periodo') return 'Reporte de Impuestos por NIT y Periodo';
      if (ty === 'nit-cuenta') return 'Reporte de Impuestos por NIT y Cuenta de Cobro';
      if (ty === 'nit-documento') return 'Reporte de Impuestos por NIT y Documento';
      if (ty === 'lista-radicados') return 'Reporte de Impuestos por Lista de Radicados';
    } else if (sec === 'circular030') {
      if (ty === 'fepa') return 'Formato Circular 030 - Archivo FEPA';
      if (ty === 'cruce') return 'Formato Circular 030 - Archivo de Cruce';
    }
    return 'Consulta de Reportes de Tesorería';
  });

  // Controls input displays
  showNitField = computed(() => true);
  showCcField = computed(() => this.type() === 'nit-cuenta');
  isCcRequired = computed(() => this.section() === 'recobros' || this.section() === 'cartera' || this.section() === 'tesoreria');
  showRadicadoField = computed(() => this.type() === 'radicado' || this.type() === 'lista-radicados');
  isRadicadoRequired = computed(() => true);
  showFacturaField = computed(() => this.type() === 'nit-factura');
  showPeriodoField = computed(() => this.type() === 'nit-periodo' || this.section() === 'circular030');
  isPeriodoRequired = computed(() => false);
  showDocPagoField = computed(() => this.type() === 'nit-documento');

  // Fallback table columns
  tableColumns = computed(() => {
    const sec = this.section();
    const formatCurrency = (val: number) => `$ ${val?.toLocaleString?.('es-CO') ?? val}`;

    if (sec === 'recobros') {
      return [
        { header: 'Nro. Contrato', field: 'numero_contrato' },
        { header: 'NIT Prestador', field: 'nit' },
        { header: 'Nombre IPS', field: 'nombre_ips' },
        { header: 'Nro. Radicado', field: 'numero_radicado' },
        { header: 'Factura', field: 'idfactura' },
        { header: 'Val. Facturado', field: 'valor_facturado', format: formatCurrency },
        { header: 'Val. Glosado', field: 'valor_glosado', format: formatCurrency },
        { header: 'Val. Pagado', field: 'valor_pagado', format: formatCurrency },
        { header: 'Saldo Pendiente', field: 'valor_saldo', format: formatCurrency }
      ];
    } else if (sec === 'cartera') {
      return [
        { header: 'Nro. Contrato', field: 'numero_contrato' },
        { header: 'Modalidad', field: 'modalidad' },
        { header: 'NIT Prestador', field: 'nit' },
        { header: 'Nombre IPS', field: 'nombre_ips' },
        { header: 'Nro. Radicado', field: 'numero_radicado' },
        { header: 'Cuenta Cobro', field: 'numero_cuenta_cobro' },
        { header: 'Val. Facturado', field: 'valor_facturado', format: formatCurrency },
        { header: 'Val. Saldo', field: 'valor_saldo', format: formatCurrency }
      ];
    } else {
      return [
        { header: 'NIT Prestador', field: 'nit' },
        { header: 'Nombre IPS', field: 'nombre_ips' },
        { header: 'Nro. Radicado', field: 'numero_radicado' },
        { header: 'Cuenta Cobro', field: 'numero_cuenta_cobro' },
        { header: 'Documento', field: 'documento' },
        { header: 'Débito', field: 'debito' },
        { header: 'Crédito', field: 'credito' },
        { header: 'Neto', field: 'neto' }
      ];
    }
  });

  activeColumns = computed(() => {
    if (this.dynamicColumns().length > 0) {
      return this.dynamicColumns();
    }
    return this.tableColumns();
  });

  constructor(
    private route: ActivatedRoute,
    private router: Router,
    private mockService: MockDataService,
    private reportApiService: ReportApiService
  ) {
    effect(() => {
      this.section();
      this.type();
      this.results.set([]);
      this.dynamicColumns.set([]);
      this.searched.set(false);
      this.lastDownload.set(null);
      this.lastBlob = null;
      this.showPreview.set(false);
      this.currentPage.set(1);
      this.clearFilters();
    }, { allowSignalWrites: true });
  }

  ngOnInit(): void {
    const parseUrl = () => {
      const segments = this.router.url.split('?')[0].split('/').filter(Boolean);
      if (segments.length >= 3) {
        this.section.set(segments[1]);
        this.type.set(segments[2]);
      } else if (segments.length === 2) {
        this.section.set(segments[0]);
        this.type.set(segments[1]);
      }
    };

    parseUrl();
    this.router.events.subscribe(() => parseUrl());
  }

  goToPage(page: number): void {
    if (page >= 1 && page <= this.totalPages()) {
      this.currentPage.set(page);
    }
  }

  nextPage(): void {
    this.goToPage(this.currentPage() + 1);
  }

  prevPage(): void {
    this.goToPage(this.currentPage() - 1);
  }

  onPageSizeChange(size: any): void {
    const parsed = Number(size) || 25;
    this.pageSize.set(parsed);
    this.currentPage.set(1);
  }

  clearFilters(): void {
    this.filters = {
      nit: '',
      cuentaCobro: '',
      radicado: '',
      factura: '',
      periodo: '',
      documentoPago: '',
      fechaInicio: '',
      fechaFin: ''
    };
  }

  resetForm(form: any): void {
    form.resetForm();
    this.clearFilters();
    this.results.set([]);
    this.dynamicColumns.set([]);
    this.searched.set(false);
    this.lastDownload.set(null);
    this.lastBlob = null;
    this.showPreview.set(false);
    this.currentPage.set(1);
  }

  togglePreview(): void {
    this.showPreview.update(v => !v);
  }

  onDownloadAgain(): void {
    if (this.lastBlob) {
      const sec = this.section() as any;
      const ty = this.type();
      const downloadName = this.lastDownload()?.fileName || this.reportApiService.buildDownloadName(sec, ty, this.filters);
      const url = window.URL.createObjectURL(this.lastBlob);
      const a = document.createElement('a');
      a.href = url;
      a.download = downloadName;
      document.body.appendChild(a);
      a.click();
      document.body.removeChild(a);
      window.URL.revokeObjectURL(url);
    } else {
      this.onSearch();
    }
  }

  onSearch(): void {
    this.loading.set(true);
    this.searched.set(false);
    this.lastDownload.set(null);
    this.lastBlob = null;
    this.results.set([]);
    this.dynamicColumns.set([]);
    this.showPreview.set(false);

    const sec = this.section() as any;
    const ty = this.type();

    this.reportApiService.fetchReport(sec, ty, this.filters).subscribe({
      next: async (blob: Blob) => {
        try {
          this.lastBlob = blob;
          const downloadName = this.reportApiService.buildDownloadName(sec, ty, this.filters);

          const sizeKb = blob.size / 1024;
          const blobSize = sizeKb >= 1024
            ? `${(sizeKb / 1024).toFixed(2)} MB`
            : `${sizeKb.toFixed(1)} KB`;

          const text = await blob.text();
          const { columns, records, totalRecords } = this.parseCsvSample(text, 25);

          if (totalRecords > 0) {
            // Descarga automática e inmediata del archivo en el navegador
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = downloadName;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            window.URL.revokeObjectURL(url);

            this.dynamicColumns.set(columns);
            this.results.set(records);
            this.lastDownload.set({
              fileName: downloadName,
              blobSize,
              recordCount: totalRecords,
              timestamp: new Date()
            });
          } else {
            this.results.set([]);
            this.lastDownload.set(null);
          }
        } catch (e) {
          console.error('Error al procesar el insumo:', e);
        } finally {
          this.searched.set(true);
          this.loading.set(false);
        }
      },
      error: (err) => {
        console.error('Error al descargar el insumo desde backend:', err);
        this.searched.set(true);
        this.loading.set(false);
      }
    });
  }

  onDownload(): void {
    this.onDownloadAgain();
  }

  private parseCsvSample(csvText: string, maxRows = 25): { columns: { header: string; field: string }[]; records: any[]; totalRecords: number } {
    if (!csvText || !csvText.trim()) return { columns: [], records: [], totalRecords: 0 };
    const lines = csvText.split(/\r?\n/).map(l => l.trim()).filter(l => l.length > 0);
    if (lines.length <= 1) return { columns: [], records: [], totalRecords: 0 };

    const totalRecords = lines.length - 1;
    const headerLine = lines[0];
    const delimiter = headerLine.includes(';') ? ';' : (headerLine.includes('\t') ? '\t' : ',');

    const rawHeaders = headerLine.split(delimiter).map(h => h.replace(/^["']|["']$/g, '').trim());

    const headerLabelMap: Record<string, string> = {
      'nit': 'NIT Prestador',
      'nombre_ips': 'Nombre IPS',
      'numero_radicado': 'Nro. Radicado',
      'numero_cuenta_cobro': 'Cuenta Cobro',
      'id_numero_cuenta_cobro': 'Cuenta Cobro',
      'documento': 'Documento / Factura',
      'idfactura': 'Factura',
      'fecha': 'Fecha',
      'debito': 'Débito',
      'credito': 'Crédito',
      'neto': 'Valor Neto',
      'valor': 'Valor',
      'valor_facturado': 'Val. Facturado',
      'valor_glosado': 'Val. Glosado',
      'valor_pagado': 'Val. Pagado',
      'valor_saldo': 'Saldo Pendiente',
      'codigo_regional': 'Cod. Regional',
      'codigo_regional_documento': 'Cod. Reg. Docto',
      'auxiliar': 'Auxiliar',
      'descripcion_auxiliar': 'Desc. Auxiliar',
      'tipo_movimiento': 'Tipo Movimiento',
      'tipo_impuesto': 'Tipo Impuesto',
      'nota': 'Nota',
      'numero_pagos': 'Nro. Pagos',
      'tasa_impuesto_unoe': 'Tasa Imp. UNOE',
      'base_impuesto_unoe': 'Base Imp. UNOE',
      'tasa_impuesto_real': 'Tasa Imp. Real',
      'base_impuesto_real': 'Base Imp. Real',
      'fecha_creacion': 'Fecha Creación',
      'fecha_aprobacion': 'Fecha Aprobación'
    };

    const columns = rawHeaders.map(h => {
      const field = h.toLowerCase();
      const label = headerLabelMap[field] || h.replace(/_/g, ' ').replace(/\b\w/g, c => c.toUpperCase());
      return { header: label, field: h };
    });

    const sampleCount = Math.min(lines.length, maxRows + 1);
    const records: any[] = [];
    for (let i = 1; i < sampleCount; i++) {
      const values = lines[i].split(delimiter).map(v => v.replace(/^["']|["']$/g, '').trim());
      const row: Record<string, any> = {};
      rawHeaders.forEach((header, index) => {
        row[header] = values[index] ?? '';
      });
      records.push(row);
    }

    return { columns, records, totalRecords };
  }

  getCellValue(row: any, col: { field: string; format?: (val: any) => string }): string {
    const val = row[col.field];
    if (val === null || val === undefined) return '';
    return col.format ? col.format(val) : String(val);
  }
}
