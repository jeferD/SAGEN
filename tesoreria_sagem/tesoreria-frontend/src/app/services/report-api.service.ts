import { HttpClient, HttpParams } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { firstValueFrom } from 'rxjs';

export interface ReportFilters {
  nit: string;
  cuentaCobro: string;
  radicado: string;
  factura: string;
  periodo: string;
  documentoPago: string;
  fechaInicio: string;
  fechaFin: string;
}

type ReportSection = 'recobros' | 'cartera' | 'tesoreria' | 'impuestos' | 'circular030';

@Injectable({
  providedIn: 'root'
})
export class ReportApiService {
  private readonly baseUrl = 'http://localhost:9299/api/reportes';

  constructor(private http: HttpClient) { }

  fetchReport(section: ReportSection, type: string, filters: ReportFilters) {
    const route = this.resolveRoute(section, type);
    const params = this.buildParams(filters);
    const url = `${this.baseUrl}${route}`;

    if (section === 'recobros') {
      return this.http.get(url, { params, responseType: 'blob' as const });
    }

    return this.http.post(url, null, { params, responseType: 'blob' as const });
  }

  buildDownloadName(section: ReportSection, type: string, filters: ReportFilters): string {
    const today = new Date().toISOString().split('T')[0];

    if (section === 'recobros') {
      if (type === 'radicado') return `${today}_NUMERO_RADICADO_${this.clean(filters.radicado)}.csv`;
      if (type === 'nit-factura') return `${today}_PAGOS_NIT_${this.clean(filters.nit)}_NUMERO_FACTURA_${this.clean(filters.factura)}.csv`;
      return `${today}_NIT_${this.clean(filters.nit)}_NUMERO_CUENTA_COBRO_${this.clean(filters.cuentaCobro)}.csv`;
    }

    if (section === 'cartera') {
      if (type === 'lista-radicados') return `${today}_CARTERA_POR_RADICADOS.csv`;
      if (type === 'nit-periodo') {
        return this.isBlank(filters.fechaInicio) || this.isBlank(filters.fechaFin)
          ? `${today}_CARTERA_NIT_${this.clean(filters.nit)}.csv`
          : `${today}_CARTERA_NIT_${this.clean(filters.nit)}_PERIODO_ENTRE_${this.clean(filters.fechaInicio)}_A_${this.clean(filters.fechaFin)}.csv`;
      }
      return `${today}_CARTERA_NIT_${this.clean(filters.nit)}_NUMERO_CUENTA_COBRO_${this.clean(filters.cuentaCobro)}.csv`;
    }

    if (section === 'tesoreria') {
      if (type === 'lista-radicados') return `${today}_PAGOS_POR_RADICADOS.csv`;
      if (type === 'nit-periodo') {
        return this.isBlank(filters.fechaInicio) || this.isBlank(filters.fechaFin)
          ? `${today}_PAGOS_NIT_${this.clean(filters.nit)}.csv`
          : `${today}_PAGOS_NIT_${this.clean(filters.nit)}_PERIODO_ENTRE_${this.clean(filters.fechaInicio)}_A_${this.clean(filters.fechaFin)}.csv`;
      }
      if (type === 'nit-documento') return `${today}_PAGOS_NIT_${this.clean(filters.nit)}_NUMERO_DOCUMENTO_PAGO_${this.clean(filters.documentoPago)}.csv`;
      return `${today}_PAGOS_NIT_${this.clean(filters.nit)}_NUMERO_CUENTA_COBRO_${this.clean(filters.cuentaCobro)}.csv`;
    }

    if (section === 'impuestos') {
      if (type === 'lista-radicados') return `${today}_IMPUESTOS_POR_RADICADOS.csv`;
      if (type === 'nit-periodo') return `${today}_PAGOS_NIT_${this.clean(filters.nit)}.csv`;
      if (type === 'nit-documento') return `${today}_IMPUESTOS_NIT_${this.clean(filters.nit)}_NUMERO_DOCUMENTO_IMPUESTO_${this.clean(filters.documentoPago)}.csv`;
      return `${today}_PAGOS_NIT_${this.clean(filters.nit)}_NUMERO_CUENTA_COBRO_${this.clean(filters.cuentaCobro)}.csv`;
    }

    return `${today}_${section.toUpperCase()}_${type.toUpperCase()}.csv`;
  }

  private resolveRoute(section: ReportSection, type: string): string {
    const map: Record<string, string> = {
      'recobros/nit-cuenta': '/recobros/cuenta-cobro',
      'recobros/nit-factura': '/recobros/factura',
      'recobros/radicado': '/recobros/radicado',
      'cartera/nit-periodo': '/cartera/nit-periodo',
      'cartera/nit-cuenta': '/cartera/nit-cuenta-cobro',
      'cartera/lista-radicados': '/cartera/radicados',
      'tesoreria/nit-periodo': '/tesoreria/nit-periodo',
      'tesoreria/nit-cuenta': '/tesoreria/nit-cuenta-cobro',
      'tesoreria/nit-documento': '/tesoreria/nit-documento',
      'tesoreria/lista-radicados': '/tesoreria/radicados',
      'impuestos/nit-periodo': '/impuestos/nit-periodo',
      'impuestos/nit-cuenta': '/impuestos/nit-cuenta-cobro',
      'impuestos/nit-documento': '/impuestos/nit-documento',
      'impuestos/lista-radicados': '/impuestos/radicados',
      'circular030/fepa': '/fepa',
      'circular030/cruce': '/cruce'
    };

    const key = `${section}/${type}`;
    const route = map[key];
    if (!route) {
      throw new Error(`Ruta no soportada: ${key}`);
    }
    return route;
  }

  private buildParams(filters: ReportFilters): HttpParams {
    let params = new HttpParams();
    for (const [key, value] of Object.entries(filters)) {
      if (value !== undefined && value !== null && value !== '') {
        params = params.set(this.toParamKey(key), value);
      }
    }
    return params;
  }

  private toParamKey(key: string): string {
    const map: Record<string, string> = {
      nit: 'txtnit',
      cuentaCobro: 'txtctacobro',
      radicado: 'txtidrad',
      factura: 'txtdocto',
      periodo: 'txtperiodo',
      documentoPago: 'txtdocto',
      fechaInicio: 'fini',
      fechaFin: 'ffin'
    };
    return map[key] ?? key;
  }

  private clean(value: string): string {
    return (value ?? '').trim().replace(/[\r\n,]/g, '_');
  }

  private isBlank(value: string): boolean {
    return !value || value.trim() === '';
  }
}
