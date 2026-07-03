import { Component, OnInit, signal } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ActivatedRoute, Router, RouterLink } from '@angular/router';
import { MockDataService, PqrsRecord } from '../../../services/mock-data.service';

@Component({
  selector: 'app-pqrs-detail',
  standalone: true,
  imports: [CommonModule, RouterLink],
  template: `
    <div class="pqrs-detail-container animate-fade-in" *ngIf="record()">
      <div class="card">
        
        <div class="card-title">
          <span><i class="bi bi-file-earmark-medical-fill"></i> Detalle de PQRS - Caso Nro. {{ record()?.no_caso }}</span>
          <div class="header-actions">
            <a [routerLink]="['/pqrs/actualizar', record()?.id]" class="btn btn-primary btn-sm">
              <i class="bi bi-pencil-square"></i> Modificar RCV
            </a>
            <a routerLink="/pqrs/lista" class="btn btn-secondary btn-sm">
              <i class="bi bi-arrow-left"></i> Volver a Bandeja
            </a>
          </div>
        </div>

        <!-- Detail Grid Blocks -->
        <div class="details-section">
          <h4 class="section-subtitle">Información del Radicado</h4>
          <div class="detail-grid">
            <div class="grid-item">
              <span class="grid-label">ID de Registro:</span>
              <span class="grid-value">{{ record()?.id }}</span>
            </div>
            <div class="grid-item">
              <span class="grid-label">Código de Registro:</span>
              <span class="grid-value">{{ record()?.cod_registro }}</span>
            </div>
            <div class="grid-item">
              <span class="grid-label">Fecha de Radicación:</span>
              <span class="grid-value">{{ record()?.fecha_rad }}</span>
            </div>
            <div class="grid-item">
              <span class="grid-label">Fecha Envío Gestión:</span>
              <span class="grid-value">{{ record()?.fecha_envio_ges }}</span>
            </div>
          </div>
        </div>

        <div class="details-section mt-6">
          <h4 class="section-subtitle">Datos del Solicitante / Afiliado</h4>
          <div class="detail-grid">
            <div class="grid-item">
              <span class="grid-label">Nombres Completos:</span>
              <span class="grid-value highlight-text">{{ record()?.nombres }}</span>
            </div>
            <div class="grid-item">
              <span class="grid-label">Documento Identidad:</span>
              <span class="grid-value">{{ record()?.tipo_id }} - {{ record()?.docto_id }}</span>
            </div>
            <div class="grid-item">
              <span class="grid-label">Ciudad:</span>
              <span class="grid-value">{{ record()?.ciudad }}</span>
            </div>
            <div class="grid-item">
              <span class="grid-label">Departamento:</span>
              <span class="grid-value">{{ record()?.departamento }}</span>
            </div>
          </div>
        </div>

        <div class="details-section mt-6">
          <h4 class="section-subtitle">Especificaciones de la PQRS</h4>
          <div class="detail-grid">
            <div class="grid-item">
              <span class="grid-label">Tipo de Solicitud:</span>
              <span class="grid-value"><span class="badge badge-primary">{{ record()?.tipo }}</span></span>
            </div>
            <div class="grid-item">
              <span class="grid-label">Régimen / Plan:</span>
              <span class="grid-value">{{ record()?.plan }}</span>
            </div>
            <div class="grid-item">
              <span class="grid-label">IPS Destino:</span>
              <span class="grid-value">{{ record()?.ips }}</span>
            </div>
            <div class="grid-item">
              <span class="grid-label">Fecha Vencimiento:</span>
              <span class="grid-value">{{ record()?.fecha_venc }}</span>
            </div>
            <div class="grid-item col-span-2">
              <span class="grid-label">Motivo Principal:</span>
              <span class="grid-value">{{ record()?.motivo }}</span>
            </div>
            <div class="grid-item col-span-2">
              <span class="grid-label">Cambio de Motivo:</span>
              <span class="grid-value">{{ record()?.cambio_motivo }}</span>
            </div>
            <div class="grid-item col-span-2">
              <span class="grid-label">Diagnóstico Relacionado:</span>
              <span class="grid-value">{{ record()?.diagnostico }}</span>
            </div>
            <div class="grid-item col-span-4">
              <span class="grid-label">Especificación / Observaciones Iniciales:</span>
              <div class="text-block">{{ record()?.observaciones }}</div>
            </div>
          </div>
        </div>

        <div class="details-section mt-6 highlighted-section">
          <h4 class="section-subtitle text-primary">Información de Gestión de Cartera RCV</h4>
          <div class="detail-grid">
            <div class="grid-item">
              <span class="grid-label">Responsable Reportado:</span>
              <span class="grid-value">{{ record()?.responsable }}</span>
            </div>
            <div class="grid-item">
              <span class="grid-label">Asignado de Gestión:</span>
              <span class="grid-value">{{ record()?.responsable_ges || 'SIN ASIGNAR' }}</span>
            </div>
            <div class="grid-item">
              <span class="grid-label">Estado Actual del Caso:</span>
              <span class="grid-value">
                <span class="badge" [class]="getStatusClass(record()?.estado)">
                  {{ record()?.estado }}
                </span>
              </span>
            </div>
            <div class="grid-item">
              <span class="grid-label">Fecha de Envío:</span>
              <span class="grid-value">{{ record()?.fecha_envio || 'No Registrado' }}</span>
            </div>
            <div class="grid-item">
              <span class="grid-label">Fecha de Entrega Gestión:</span>
              <span class="grid-value">{{ record()?.fecha_entrega_ges }}</span>
            </div>
            <div class="grid-item">
              <span class="grid-label">Tiempo de Gestión:</span>
              <span class="grid-value">{{ record()?.tiempo_gestion }}</span>
            </div>
            <div class="grid-item col-span-4">
              <span class="grid-label">Observaciones / Gestión RCV Realizada:</span>
              <div class="text-block bg-light">{{ record()?.observacion || 'Ninguna observación registrada por el gestor.' }}</div>
            </div>
            <div class="grid-item col-span-4">
              <span class="grid-label">Observación Final PQRS:</span>
              <div class="text-block bg-light">{{ record()?.observ_pqrs || 'Ninguna observación final registrada.' }}</div>
            </div>
          </div>
        </div>

      </div>
    </div>

    <div class="card animate-fade-in text-center py-8" *ngIf="!record() && loaded()">
      <i class="bi bi-x-circle text-danger font-lg"></i>
      <h3>Caso no encontrado</h3>
      <p class="text-muted">El código de PQRS especificado no existe o ha sido eliminado.</p>
      <a routerLink="/pqrs/lista" class="btn btn-secondary mt-4">
        Volver a la bandeja de casos
      </a>
    </div>
  `,
  styles: [`
    .pqrs-detail-container {
      display: flex;
      flex-direction: column;
      gap: 20px;
    }

    .header-actions {
      display: flex;
      gap: 10px;
    }

    .details-section {
      border-top: 1px solid var(--neutral-200);
      padding-top: 20px;
    }

    .details-section.mt-6 {
      margin-top: 24px;
    }

    .section-subtitle {
      font-size: 0.95rem;
      font-weight: 700;
      color: var(--neutral-600);
      text-transform: uppercase;
      letter-spacing: 0.5px;
      margin-bottom: 16px;
    }

    .text-primary {
      color: var(--primary-color) !important;
    }

    .highlighted-section {
      background-color: var(--neutral-50);
      padding: 20px;
      border-radius: var(--border-radius-md);
      border: 1px dashed var(--neutral-300);
    }

    .detail-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 16px;
    }

    .grid-item {
      display: flex;
      flex-direction: column;
      gap: 4px;
    }

    .grid-item.col-span-2 {
      grid-column: span 2;
    }

    .grid-item.col-span-4 {
      grid-column: span 4;
    }

    .grid-label {
      font-size: 0.75rem;
      font-weight: 600;
      color: var(--neutral-400);
      text-transform: uppercase;
    }

    .grid-value {
      font-size: 0.9rem;
      color: var(--neutral-800);
      font-weight: 500;
    }

    .highlight-text {
      color: var(--primary-dark);
      font-weight: 600;
    }

    .text-block {
      background-color: var(--neutral-100);
      border: 1px solid var(--neutral-200);
      border-radius: var(--border-radius-sm);
      padding: 12px;
      font-size: 0.875rem;
      color: var(--neutral-700);
      line-height: 1.6;
      min-height: 50px;
    }

    .text-block.bg-light {
      background-color: white;
    }

    .text-center {
      text-align: center;
    }

    .py-8 {
      padding: 32px 0;
    }

    .mt-4 {
      margin-top: 16px;
    }

    .font-lg {
      font-size: 3rem;
      margin-bottom: 12px;
      display: block;
    }

    @media (max-width: 768px) {
      .detail-grid {
        grid-template-columns: 1fr;
      }
      .grid-item.col-span-2, .grid-item.col-span-4 {
        grid-column: span 1;
      }
    }
  `]
})
export class PqrsDetailComponent implements OnInit {
  record = signal<PqrsRecord | undefined>(undefined);
  loaded = signal(false);

  constructor(
    private route: ActivatedRoute,
    private router: Router,
    private mockService: MockDataService
  ) {}

  ngOnInit(): void {
    const idParam = this.route.snapshot.paramMap.get('id');
    if (idParam) {
      const id = parseInt(idParam, 10);
      const data = this.mockService.getPqrsById(id);
      this.record.set(data);
    }
    this.loaded.set(true);
  }

  getStatusClass(status: string | undefined): string {
    if (!status) return 'badge-secondary';
    const s = status.toUpperCase();
    if (s === 'ABIERTO') return 'badge-warning';
    if (s === 'EN PROCESO') return 'badge-primary';
    if (s === 'CERRADO') return 'badge-success';
    return 'badge-secondary';
  }
}
