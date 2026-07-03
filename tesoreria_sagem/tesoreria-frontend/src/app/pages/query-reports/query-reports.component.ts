import { Component, OnInit, signal, computed, effect } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { ActivatedRoute, Router } from '@angular/router';
import { MockDataService, FacturaRecord } from '../../services/mock-data.service';

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

            <!-- Periodo Field -->
            <div class="form-group" *ngIf="showPeriodoField()">
              <label class="form-label">Periodo <span class="required">*</span></label>
              <select class="form-control" name="txtperiodo" [(ngModel)]="filters.periodo" required>
                <option value="" disabled selected>Seleccione Periodo</option>
                <option value="2025-12">Diciembre 2025</option>
                <option value="2026-01">Enero 2026</option>
                <option value="2026-02">Febrero 2026</option>
                <option value="2026-03">Marzo 2026</option>
                <option value="2026-04">Abril 2026</option>
                <option value="2026-05">Mayo 2026</option>
              </select>
            </div>

            <!-- Date Range Fields (Initial / Final Period) -->
            <div class="form-group" *ngIf="showDateRangeFields()">
              <label class="form-label">Periodo de pago inicial <span class="required">*</span></label>
              <input type="date" class="form-control" name="txtfini" [(ngModel)]="filters.fechaInicio" required>
            </div>
            <div class="form-group" *ngIf="showDateRangeFields()">
              <label class="form-label">Periodo de pago final <span class="required">*</span></label>
              <input type="date" class="form-control" name="txtffin" [(ngModel)]="filters.fechaFin" required>
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
            <button type="submit" class="btn btn-primary" [disabled]="!searchForm.form.valid">
              <i class="bi bi-search"></i> CONSULTAR
            </button>
            <button type="button" class="btn btn-secondary" (click)="resetForm(searchForm)">
              <i class="bi bi-arrow-counterclockwise"></i> LIMPIAR
            </button>
            <button 
              type="button" 
              class="btn btn-success" 
              [disabled]="results().length === 0" 
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
                <th *ngFor="let col of tableColumns()">{{ col.header }}</th>
              </tr>
            </thead>
            <tbody>
              <tr *ngFor="let row of results()">
                <td *ngFor="let col of tableColumns()">
                  {{ col.format ? col.format(getFieldValue(row, col.field)) : getFieldValue(row, col.field) }}
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
  `]
})
export class QueryReportsComponent implements OnInit {
  // Route params state
  section = signal<string>('');
  type = signal<string>('');

  // Search filter inputs
  filters = {
    nit: '',
    cuentaCobro: '',
    radicado: '',
    factura: '',
    periodo: '',
    documentoPago: '',
    fechaInicio: '',
    fechaFin: ''
  };

  searched = signal(false);
  results = signal<FacturaRecord[]>([]);

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
  showNitField = computed(() => {
    // Almost always shown except for standalone radicado lists in some modules
    return true;
  });

  showCcField = computed(() => {
    const ty = this.type();
    return ty === 'nit-cuenta';
  });

  isCcRequired = computed(() => {
    // In original recobros_nit_+_numero_cuenta_cobro it has CC as optional or required depending on module
    return this.section() === 'recobros' || this.section() === 'cartera' || this.section() === 'tesoreria';
  });

  showRadicadoField = computed(() => {
    const ty = this.type();
    return ty === 'radicado' || ty === 'lista-radicados';
  });

  isRadicadoRequired = computed(() => {
    return true;
  });

  showFacturaField = computed(() => {
    return this.type() === 'nit-factura';
  });

  showPeriodoField = computed(() => {
    return this.section() === 'circular030';
  });

  showDateRangeFields = computed(() => {
    return this.type() === 'nit-periodo';
  });

  showDocPagoField = computed(() => {
    return this.type() === 'nit-documento';
  });

  // Dynamic table columns based on section
  tableColumns = computed(() => {
    const sec = this.section();
    const formatCurrency = (val: number) => `$ ${val.toLocaleString('es-CO')}`;

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
    } else if (sec === 'tesoreria') {
      return [
        { header: 'NIT Prestador', field: 'nit' },
        { header: 'Nombre IPS', field: 'nombre_ips' },
        { header: 'Nro. Radicado', field: 'numero_radicado' },
        { header: 'Cuenta Cobro', field: 'numero_cuenta_cobro' },
        { header: 'Documento Pago', field: 'documento_pago' },
        { header: 'Fecha Pago', field: 'fecha_pago' },
        { header: 'Val. Pagado', field: 'valor_pagado', format: formatCurrency },
        { header: 'Val. Pagado Total', field: 'valor_pagado_total', format: formatCurrency }
      ];
    } else if (sec === 'impuestos') {
      return [
        { header: 'Nro. Contrato', field: 'numero_contrato' },
        { header: 'NIT Prestador', field: 'nit' },
        { header: 'Nombre IPS', field: 'nombre_ips' },
        { header: 'Cuenta Cobro', field: 'numero_cuenta_cobro' },
        { header: 'Nro. Radicado', field: 'numero_radicado' },
        { header: 'Val. Facturado', field: 'valor_facturado', format: formatCurrency },
        { header: 'Impuesto Real', field: 'valor_impuesto_real', format: formatCurrency },
        { header: 'Impuesto Contable', field: 'valor_impuesto_contable', format: formatCurrency }
      ];
    } else {
      // circular030
      return [
        { header: 'NIT Prestador', field: 'nit' },
        { header: 'Nombre IPS', field: 'nombre_ips' },
        { header: 'Nro. Radicado', field: 'numero_radicado' },
        { header: 'Factura', field: 'idfactura' },
        { header: 'Existe Conciliación', field: 'existe_conciliacion' },
        { header: 'Saldo EPS', field: 'valor_saldo', format: formatCurrency },
        { header: 'Glosa EPS', field: 'valor_glosa_favor_eps', format: formatCurrency }
      ];
    }
  });

  constructor(
    private route: ActivatedRoute,
    private mockService: MockDataService
  ) {
    // Reset results when parameters change
    effect(() => {
      this.section();
      this.type();
      this.results.set([]);
      this.searched.set(false);
      this.clearFilters();
    }, { allowSignalWrites: true });
  }

  ngOnInit(): void {
    // Subscribe to router path parameters
    this.route.url.subscribe(url => {
      if (url.length > 1) {
        this.section.set(url[0].path);
        this.type.set(url[1].path);
      }
    });
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
    this.searched.set(false);
  }

  onSearch(): void {
    this.searched.set(true);
    const queried = this.mockService.queryReports(this.section(), this.filters);
    this.results.set(queried);
  }

  onDownload(): void {
    const sec = this.section();
    const ty = this.type();
    const today = new Date().toISOString().split('T')[0];

    // Establish dynamic file naming matching legacy PHP scripts
    let filename = `${today}_REPORT_${sec.toUpperCase()}`;
    if (this.filters.nit) {
      filename += `_NIT_${this.filters.nit}`;
    }
    if (this.filters.periodo) {
      filename += `_PERIODO_${this.filters.periodo}`;
    }
    if (this.filters.cuentaCobro) {
      filename += `_CTACOBRO_${this.filters.cuentaCobro}`;
    }
    if (this.filters.documentoPago) {
      filename += `_DOCUMENTO_PAGO_${this.filters.documentoPago}`;
    }
    if (this.filters.fechaInicio) {
      filename += `_FECHA_INI_${this.filters.fechaInicio}`;
    }
    if (this.filters.fechaFin) {
      filename += `_FECHA_FIN_${this.filters.fechaFin}`;
    }
    filename += '.csv';

    const columns = this.tableColumns();
    const headers = columns.map(c => c.header);
    
    const rows = this.results().map(row => {
      return columns.map(col => {
        const val = this.getFieldValue(row, col.field);
        return col.format ? col.format(val) : val;
      });
    });

    this.mockService.downloadCsv(filename, headers, rows);
  }

  getFieldValue(row: FacturaRecord, field: string): any {
    return (row as any)[field];
  }
}
