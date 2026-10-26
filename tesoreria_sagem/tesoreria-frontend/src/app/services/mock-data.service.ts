import { Injectable, signal } from '@angular/core';

export interface EmailRecord {
  id: number;
  nit: string;
  nombre: string;
  email: string;
  activo: boolean;
}

export interface PqrsRecord {
  id: number;
  fecha_rad: string;
  fecha_envio_ges: string;
  tipo_id: string;
  docto_id: string;
  cod_registro: string;
  asignado: string;
  nombres: string;
  ciudad: string;
  departamento: string;
  especifico: string;
  motivo: string;
  cambio_motivo: string;
  diagnostico: string;
  tipo: string;
  fecha_venc: string;
  ips: string;
  observaciones: string;
  plan: string;
  no_caso: string;
  responsable: string;
  responsable_ges: string;
  fecha_entrega_ges: string;
  observacion: string;
  fecha_envio: string;
  estado: string;
  tiempo_gestion: string;
  observ_pqrs: string;
}

export interface FacturaRecord {
  numero_contrato: string;
  codigo_regional: string;
  modalidad: string;
  auxiliar: string;
  descripcion_auxiliar: string;
  nit: string;
  nombre_ips: string;
  numero_radicado: string;
  numero_cuenta_cobro: string;
  idfactura: string;
  idinterno_lazos: string;
  rips: string;
  prefijo: string;
  consecutivo: string;
  fecha_egreso: string;
  fecha_expedicion: string;
  fecha_radicacion: string;
  fecha_causacion: string;
  documento_causacion: string;
  valor_facturado: number;
  fecha_glosa_inicial: string;
  documento_glosa_inicial: string;
  valor_glosado: number;
  existe_conciliacion: string;
  fecha_conciliacion: string;
  documento_conciliacion: string;
  valor_glosa_favor_eps: number;
  valor_glosa_favor_ips: number;
  valor_impuesto_real: number;
  valor_impuesto_contable: number;
  fecha_pago: string;
  documento_pago: string;
  valor_pagado: number;
  valor_pagado_total: number;
  valor_saldo: number;
  periodo?: string; // added dynamically for queries
}

export interface CubosGraficoRecord {
  name: string;
  y: number;
}

export interface CubosIndicadorRecord {
  fecha_corte: string;
  niteps: string;
  nomeps: string;
  vrsaldoeps: string;
  vrsaldoips: string;
  diferencia: string;
  nivel: string;
}

@Injectable({
  providedIn: 'root'
})
export class MockDataService {
  private readonly EMAILS_KEY = 'sagem_mock_emails';
  private readonly PQRS_KEY = 'sagem_mock_pqrs';

  // Signals for CRUD state
  public readonly emails = signal<EmailRecord[]>([]);
  public readonly pqrsList = signal<PqrsRecord[]>([]);

  // Raw mock database for reports
  private queryDb: FacturaRecord[] = [];
  private cubosGrafica: CubosGraficoRecord[] = [];
  private cubosIndicadores: CubosIndicadorRecord[] = [];

  constructor() {
    this.initMockData();
  }

  private initMockData(): void {
    // Load or set Emails
    const savedEmails = localStorage.getItem(this.EMAILS_KEY);
    if (savedEmails) {
      this.emails.set(JSON.parse(savedEmails));
    } else {
      const defaultEmails: EmailRecord[] = [
        { id: 1, nit: '900123456', nombre: 'CLINICA VALLE DEL LILI', email: 'facturacion@valledellili.com', activo: true },
        { id: 2, nit: '890321654', nombre: 'HOSPITAL UNIVERSITARIO DE NARIÑO', email: 'tesoreria@hospitalnarinio.gov.co', activo: true },
        { id: 3, nit: '800555444', nombre: 'IMBANCO S.A.', email: 'cartera@imbaco.com.co', activo: true },
        { id: 4, nit: '900222333', nombre: 'CLINICA DEMENTE S.A.S.', email: 'contabilidad@clinicademente.com', activo: true },
        { id: 5, nit: '800999000', nombre: 'FUNDACION VALLE DEL RUT', email: 'recaudos@fundacionvalle.org', activo: true }
      ];
      this.emails.set(defaultEmails);
      this.saveEmailsToStorage(defaultEmails);
    }

    // Load or set PQRS
    const savedPqrs = localStorage.getItem(this.PQRS_KEY);
    if (savedPqrs) {
      this.pqrsList.set(JSON.parse(savedPqrs));
    } else {
      const defaultPqrs: PqrsRecord[] = [
        {
          id: 101,
          fecha_rad: '2026-06-01',
          fecha_envio_ges: '2026-06-02',
          tipo_id: 'CC',
          docto_id: '12345678',
          cod_registro: 'REG-101',
          asignado: 'SILVIA BASTIDAS',
          nombres: 'JUAN PEREZ GOMEZ',
          ciudad: 'PASTO',
          departamento: 'NARIÑO',
          especifico: 'Falta de pago de incapacidades',
          motivo: 'Reclamación de pagos',
          cambio_motivo: 'Ninguno',
          diagnostico: 'G40.9',
          tipo: 'RECLAMO',
          fecha_venc: '2026-06-15',
          ips: 'HOSPITAL DE PASTO',
          observaciones: 'Paciente solicita con urgencia el desembolso de los pagos acumulados.',
          plan: 'CONTRIBUTIVO',
          no_caso: 'CASO-001',
          responsable: 'SILVIA BASTIDAS',
          responsable_ges: 'SILVIA BASTIDAS',
          fecha_entrega_ges: '2026-06-10',
          observacion: 'Gestión iniciada ante tesorería.',
          fecha_envio: '2026-06-03',
          estado: 'EN PROCESO',
          tiempo_gestion: '5 días',
          observ_pqrs: 'Seguimiento programado para el lunes.'
        },
        {
          id: 102,
          fecha_rad: '2026-06-05',
          fecha_envio_ges: '2026-06-06',
          tipo_id: 'CC',
          docto_id: '87654321',
          cod_registro: 'REG-102',
          asignado: 'VANESSA MORENO',
          nombres: 'MARIA RODRIGUEZ DIAZ',
          ciudad: 'CALI',
          departamento: 'VALLE DEL CAUCA',
          especifico: 'Conciliación de saldos de cartera',
          motivo: 'Conciliaciones',
          cambio_motivo: 'Ninguno',
          diagnostico: 'Z00.0',
          tipo: 'PETICION',
          fecha_venc: '2026-06-20',
          ips: 'CLINICA VALLE DEL LILI',
          observaciones: 'IPS solicita cruce de cartera del periodo diciembre 2025.',
          plan: 'CONTRIBUTIVO',
          no_caso: 'CASO-002',
          responsable: 'VANESSA MORENO',
          responsable_ges: 'VANESSA MORENO',
          fecha_entrega_ges: '1990-01-01',
          observacion: 'Pendiente envío de soporte por parte de IPS.',
          fecha_envio: '2026-06-07',
          estado: 'ABIERTO',
          tiempo_gestion: '0',
          observ_pqrs: ''
        }
      ];
      this.pqrsList.set(defaultPqrs);
      this.savePqrsToStorage(defaultPqrs);
    }

    // Pre-populate database for searching reports (Recobros, Cartera, Tesoreria, Impuestos)
    const nits = ['900123456', '890321654', '800555444', '900222333', '800999000'];
    const nombres = ['CLINICA VALLE DEL LILI', 'HOSPITAL UNIVERSITARIO DE NARIÑO', 'IMBANCO S.A.', 'CLINICA DEMENTE S.A.S.', 'FUNDACION VALLE DEL RUT'];
    const periodos = ['2025-12', '2026-01', '2026-02', '2026-03', '2026-04', '2026-05'];

    for (let i = 0; i < 50; i++) {
      const idx = i % nits.length;
      const nit = nits[idx];
      const name = nombres[idx];
      const radicado = (100000 + i).toString();
      const ctacobro = (500000 + i).toString();
      const facturaId = `F-${i + 2000}`;
      const valorFacturado = 1000000 + (i * 250000);
      const valorGlosado = i % 3 === 0 ? valorFacturado * 0.1 : 0;
      const valorGlosaFavorEps = valorGlosado * 0.8;
      const valorGlosaFavorIps = valorGlosado * 0.2;
      const valorImpuestoReal = (valorFacturado - valorGlosado) * 0.04;
      const valorImpuestoContable = valorImpuestoReal * 0.95;
      const valorPagado = (valorFacturado - valorGlosado - valorImpuestoReal) * 0.9;
      const valorSaldo = valorFacturado - valorGlosado - valorPagado;
      const periodo = periodos[i % periodos.length];

      this.queryDb.push({
        numero_contrato: `CTR-${200 + i}`,
        codigo_regional: `REG-0${(i % 3) + 1}`,
        modalidad: i % 2 === 0 ? 'EVENTO' : 'CAPITA',
        auxiliar: `AX-${1000 + i}`,
        descripcion_auxiliar: 'AUXILIAR DE TESORERIA',
        nit: nit,
        nombre_ips: name,
        numero_radicado: radicado,
        numero_cuenta_cobro: ctacobro,
        idfactura: facturaId,
        idinterno_lazos: `LZ-${9000 + i}`,
        rips: `RIPS-${700 + i}`,
        prefijo: 'FE',
        consecutivo: `${1500 + i}`,
        fecha_egreso: `2026-05-${10 + (i % 20)}`,
        fecha_expedicion: `2026-04-${10 + (i % 20)}`,
        fecha_radicacion: `2026-04-${12 + (i % 20)}`,
        fecha_causacion: `2026-04-${15 + (i % 20)}`,
        documento_causacion: `CAU-${8000 + i}`,
        valor_facturado: valorFacturado,
        fecha_glosa_inicial: i % 3 === 0 ? `2026-05-02` : '',
        documento_glosa_inicial: i % 3 === 0 ? `GLO-${6000 + i}` : '',
        valor_glosado: valorGlosado,
        existe_conciliacion: i % 3 === 0 ? 'SI' : 'NO',
        fecha_conciliacion: i % 3 === 0 ? `2026-05-15` : '',
        documento_conciliacion: i % 3 === 0 ? `CONC-${4000 + i}` : '',
        valor_glosa_favor_eps: valorGlosaFavorEps,
        valor_glosa_favor_ips: valorGlosaFavorIps,
        valor_impuesto_real: valorImpuestoReal,
        valor_impuesto_contable: valorImpuestoContable,
        fecha_pago: `2026-05-${20 + (i % 10)}`,
        documento_pago: `PAG-${3000 + i}`,
        valor_pagado: valorPagado,
        valor_pagado_total: valorPagado + valorImpuestoReal,
        valor_saldo: valorSaldo,
        periodo: periodo
      });
    }

    // Cubos mock data
    this.cubosGrafica = [
      { name: 'EMSSANAR EPS', y: 15304928500 },
      { name: 'ASMET SALUD EPS', y: 8490212000 },
      { name: 'COOSALUD EPS', y: 6102943200 },
      { name: 'NUEVA EPS', y: 12498211000 },
      { name: 'MALLAMAS EPS', y: 2190433000 },
      { name: 'COMPARTA EPS', y: 1109033000 }
    ];

    this.cubosIndicadores = [
      { fecha_corte: '2020-12-31', niteps: '900012345', nomeps: 'EMSSANAR EPS', vrsaldoeps: '$ 15.304.928.500', vrsaldoips: '$ 15.295.402.100', diferencia: '$ 9.526.400', nivel: 'ALTO (99.9%)' },
      { fecha_corte: '2020-12-31', niteps: '900023456', nomeps: 'ASMET SALUD EPS', vrsaldoeps: '$ 8.490.212.000', vrsaldoips: '$ 8.120.403.000', diferencia: '$ 369.809.000', nivel: 'MEDIO (95.6%)' },
      { fecha_corte: '2020-12-31', niteps: '900034567', nomeps: 'COOSALUD EPS', vrsaldoeps: '$ 6.102.943.200', vrsaldoips: '$ 6.098.112.500', diferencia: '$ 4.830.700', nivel: 'ALTO (99.9%)' },
      { fecha_corte: '2020-12-31', niteps: '900045678', nomeps: 'NUEVA EPS', vrsaldoeps: '$ 12.498.211.000', vrsaldoips: '$ 11.905.210.000', diferencia: '$ 593.001.000', nivel: 'MEDIO (95.2%)' },
      { fecha_corte: '2020-12-31', niteps: '900056789', nomeps: 'MALLAMAS EPS', vrsaldoeps: '$ 2.190.433.000', vrsaldoips: '$ 2.189.501.000', diferencia: '$ 932.000', nivel: 'ALTO (99.9%)' }
    ];
  }

  // --- Emails CRUD ---
  private saveEmailsToStorage(emails: EmailRecord[]): void {
    localStorage.setItem(this.EMAILS_KEY, JSON.stringify(emails));
  }

  public getEmails(): EmailRecord[] {
    return this.emails().filter(e => e.activo);
  }

  public getEmailById(id: number): EmailRecord | undefined {
    return this.emails().find(e => e.id === id);
  }

  public createEmail(nit: string, nombre: string, email: string): void {
    const list = this.emails();
    const newId = list.length > 0 ? Math.max(...list.map(e => e.id)) + 1 : 1;
    const newRecord: EmailRecord = {
      id: newId,
      nit: nit.trim(),
      nombre: nombre.trim().toUpperCase(),
      email: email.trim().toLowerCase(),
      activo: true
    };
    const updated = [...list, newRecord];
    this.emails.set(updated);
    this.saveEmailsToStorage(updated);
  }

  public updateEmail(id: number, email: string): boolean {
    const list = this.emails();
    const idx = list.findIndex(e => e.id === id);
    if (idx !== -1) {
      const updated = [...list];
      updated[idx] = { ...updated[idx], email: email.trim().toLowerCase() };
      this.emails.set(updated);
      this.saveEmailsToStorage(updated);
      return true;
    }
    return false;
  }

  public deleteEmail(id: number): boolean {
    // Soft delete as in emails_ad.php (set activo = false)
    const list = this.emails();
    const idx = list.findIndex(e => e.id === id);
    if (idx !== -1) {
      const updated = [...list];
      updated[idx] = { ...updated[idx], activo: false };
      this.emails.set(updated);
      this.saveEmailsToStorage(updated);
      return true;
    }
    return false;
  }

  // --- PQRS CRUD ---
  private savePqrsToStorage(pqrs: PqrsRecord[]): void {
    localStorage.setItem(this.PQRS_KEY, JSON.stringify(pqrs));
  }

  public getPqrsList(): PqrsRecord[] {
    return this.pqrsList();
  }

  public getPqrsById(id: number): PqrsRecord | undefined {
    return this.pqrsList().find(p => p.id === id);
  }

  public createPqrs(record: Partial<PqrsRecord>): void {
    const list = this.pqrsList();
    const newId = list.length > 0 ? Math.max(...list.map(p => p.id)) + 1 : 101;
    const newRecord: PqrsRecord = {
      id: newId,
      fecha_rad: record.fecha_rad || new Date().toISOString().split('T')[0],
      fecha_envio_ges: record.fecha_envio_ges || new Date().toISOString().split('T')[0],
      tipo_id: record.tipo_id || 'CC',
      docto_id: record.docto_id || '',
      cod_registro: record.cod_registro || `REG-${newId}`,
      asignado: record.asignado || 'SIN ASIGNAR',
      nombres: (record.nombres || '').toUpperCase(),
      ciudad: (record.ciudad || '').toUpperCase(),
      departamento: (record.departamento || '').toUpperCase(),
      especifico: record.especifico || '',
      motivo: record.motivo || '',
      cambio_motivo: record.cambio_motivo || 'Ninguno',
      diagnostico: record.diagnostico || '',
      tipo: record.tipo || 'PETICION',
      fecha_venc: record.fecha_venc || '',
      ips: (record.ips || '').toUpperCase(),
      observaciones: record.observaciones || '',
      plan: record.plan || 'CONTRIBUTIVO',
      no_caso: record.no_caso || `CASO-${newId}`,
      responsable: record.responsable || '',
      responsable_ges: record.responsable_ges || '',
      fecha_entrega_ges: '1990-01-01',
      observacion: record.observacion || '',
      fecha_envio: record.fecha_envio || '',
      estado: record.estado || 'ABIERTO',
      tiempo_gestion: '0',
      observ_pqrs: record.observ_pqrs || ''
    };
    const updated = [...list, newRecord];
    this.pqrsList.set(updated);
    this.savePqrsToStorage(updated);
  }

  public updatePqrs(id: number, fields: Partial<PqrsRecord>): boolean {
    const list = this.pqrsList();
    const idx = list.findIndex(p => p.id === id);
    if (idx !== -1) {
      const updated = [...list];
      updated[idx] = {
        ...updated[idx],
        responsable_ges: fields.responsable_ges || updated[idx].responsable_ges,
        observacion: fields.observacion !== undefined ? fields.observacion : updated[idx].observacion,
        fecha_envio: fields.fecha_envio || updated[idx].fecha_envio,
        estado: fields.estado || updated[idx].estado,
        observ_pqrs: fields.observ_pqrs !== undefined ? fields.observ_pqrs : updated[idx].observ_pqrs,
        fecha_entrega_ges: fields.fecha_entrega_ges || updated[idx].fecha_entrega_ges,
        tiempo_gestion: fields.tiempo_gestion || updated[idx].tiempo_gestion
      };
      this.pqrsList.set(updated);
      this.savePqrsToStorage(updated);
      return true;
    }
    return false;
  }

  // --- Reports Query Engine ---
  public queryReports(type: string, filters: {
    nit?: string;
    cuentaCobro?: string;
    radicado?: string;
    factura?: string;
    periodo?: string;
    documentoPago?: string;
    fechaInicio?: string;
    fechaFin?: string;
  }): FacturaRecord[] {
    return this.queryDb.filter(row => {
      // Base filters
      if (filters.nit && row.nit !== filters.nit.trim()) return false;
      if (filters.cuentaCobro && row.numero_cuenta_cobro !== filters.cuentaCobro.trim()) return false;
      if (filters.radicado && row.numero_radicado !== filters.radicado.trim()) return false;
      if (filters.factura && row.idfactura !== filters.factura.trim()) return false;
      if (filters.periodo && row.periodo !== filters.periodo.trim()) return false;
      if (filters.documentoPago && row.documento_pago !== filters.documentoPago.trim()) return false;
      const rowFecha = row.fecha_radicacion || row.fecha_expedicion || row.fecha_pago || (row.periodo ? `${row.periodo}-01` : '');
      if (filters.fechaInicio && rowFecha && rowFecha < filters.fechaInicio) return false;
      if (filters.fechaFin && rowFecha && rowFecha > filters.fechaFin) return false;
      return true;
    });
  }

  // --- Cubos Data ---
  public getCubosGrafica(): CubosGraficoRecord[] {
    return this.cubosGrafica;
  }

  public getCubosIndicadores(): CubosIndicadorRecord[] {
    return this.cubosIndicadores;
  }

  // --- CSV Export Helper ---
  public downloadCsv(filename: string, headers: string[], rows: any[][]): void {
    let csvContent = headers.join(',') + '\n';
    
    rows.forEach(row => {
      const csvRow = row.map(val => {
        if (val === null || val === undefined) return '';
        // Escape commas and double quotes
        const valStr = String(val).replace(/"/g, '""');
        return valStr.includes(',') || valStr.includes('"') || valStr.includes('\n')
          ? `"${valStr}"`
          : valStr;
      }).join(',');
      csvContent += csvRow + '\n';
    });

    const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
    const url = URL.createObjectURL(blob);
    const link = document.createElement('a');
    link.setAttribute('href', url);
    link.setAttribute('download', filename);
    link.style.visibility = 'hidden';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
  }
}
