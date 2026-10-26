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
              <label class="form-label">Fecha Inicial (Desde) <span *ngIf="isPeriodoRequired()" class="required">*</span></label>
              <input 
                type="date" 
                class="form-control" 
                name="txtfini" 
                [(ngModel)]="filters.fechaInicio" 
                [required]="isPeriodoRequired()">
            </div>

            <!-- Fecha Final (Hasta) Field -->
            <div class="form-group" *ngIf="showPeriodoField()">
              <label class="form-label">Fecha Final (Hasta) <span *ngIf="isPeriodoRequired()" class="required">*</span></label>
              <input 
                type="date" 
                class="form-control" 
                name="txtffin" 
                [(ngModel)]="filters.fechaFin" 
                [required]="isPeriodoRequired()">
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

          <div class="form-actions">
            <button type="submit" class="btn btn-primary" [disabled]="!searchForm.form.valid || loading()">
              <ng-container *ngIf="loading()">
                <i class="bi bi-arrow-repeat spin"></i> Consultando...
              </ng-container>
              <ng-container *ngIf="!loading()">
                <i class="bi bi-search"></i> CONSULTAR
              </ng-container>
            </button>
            <button type="button" class="btn btn-secondary" (click)="resetForm(searchForm)" [disabled]="loading()">
              <i class="bi bi-arrow-counterclockwise"></i> LIMPIAR
            </button>
            <button 
              type="button" 
              class="btn btn-success" 
              [disabled]="results().length === 0 || loading()" 
              (click)="onDownload()">
              <i class="bi bi-cloud-arrow-down"></i> DESCARGAR CSV
            </button>
          </div>
        </form>
      </div>

      <!-- Preview Grid -->
      <div class="card animate-fade-in" *ngIf="searched()">
        <div class="card-title">
          <span><i class="bi bi-list-columns"></i> Resultados de Consulta ({{ results().length }} registros)</span>
        </div>

        <div *ngIf="results().length === 0" class="no-results">
          <i class="bi bi-search-heart font-lg"></i>
          <p>No se encontraron registros para la consulta especificada.</p>
        </div>

        <div class="table-responsive" *ngIf="results().length > 0">
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
  isPeriodoRequired = computed(() => this.type() === 'nit-periodo');
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
  }

  onSearch(): void {
    this.loading.set(true);
    this.searched.set(false);
    this.results.set([]);
    this.dynamicColumns.set([]);

    const sec = this.section() as any;
    const ty = this.type();

    // Consumir API del Backend HTTP
    this.reportApiService.fetchReport(sec, ty, this.filters).subscribe({
      next: async (blob: Blob) => {
        try {
          const text = await blob.text();
          const { columns, records } = this.parseCsvToRecords(text);
          if (records.length > 0) {
            this.dynamicColumns.set(columns);
            this.results.set(records);
          } else {
            const queried = this.mockService.queryReports(this.section(), this.filters);
            this.results.set(queried);
          }
        } catch {
          const queried = this.mockService.queryReports(this.section(), this.filters);
          this.results.set(queried);
        }
        this.searched.set(true);
        this.loading.set(false);
      },
      error: (err) => {
        console.error('Error al realizar la consulta en el backend:', err);
        const queried = this.mockService.queryReports(this.section(), this.filters);
        this.results.set(queried);
        this.searched.set(true);
        this.loading.set(false);
      }
    });
  }

  onDownload(): void {
    const sec = this.section() as any;
    const ty = this.type();

    this.reportApiService.fetchReport(sec, ty, this.filters).subscribe({
      next: (blob: Blob) => {
        const downloadName = this.reportApiService.buildDownloadName(sec, ty, this.filters);
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = downloadName;
        a.click();
        window.URL.revokeObjectURL(url);
      },
      error: (err) => {
        console.error('Error al descargar reporte desde backend:', err);
      }
    });
  }

  private parseCsvToRecords(csvText: string): { columns: { header: string; field: string }[]; records: any[] } {
    if (!csvText || !csvText.trim()) return { columns: [], records: [] };
    const lines = csvText.split(/\r?\n/).map(l => l.trim()).filter(l => l.length > 0);
    if (lines.length <= 1) return { columns: [], records: [] };

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

    const records: any[] = [];
    for (let i = 1; i < lines.length; i++) {
      const values = lines[i].split(delimiter).map(v => v.replace(/^["']|["']$/g, '').trim());
      const row: Record<string, any> = {};
      rawHeaders.forEach((header, index) => {
        const val = values[index] ?? '';
        row[header] = val;
      });
      records.push(row);
    }

    return { columns, records };
  }

  getCellValue(row: any, col: { field: string; format?: (val: any) => string }): string {
    const val = row[col.field];
    if (val === null || val === undefined) return '';
    return col.format ? col.format(val) : String(val);
  }
}
