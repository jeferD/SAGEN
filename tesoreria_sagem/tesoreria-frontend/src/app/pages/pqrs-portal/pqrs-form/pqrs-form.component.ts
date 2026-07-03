import { Component, OnInit, signal } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { ActivatedRoute, Router, RouterLink } from '@angular/router';
import { MockDataService, PqrsRecord } from '../../../services/mock-data.service';

@Component({
  selector: 'app-pqrs-form',
  standalone: true,
  imports: [CommonModule, FormsModule, RouterLink],
  template: `
    <div class="pqrs-form-container animate-fade-in">
      <div class="card">
        
        <div class="card-title">
          <span>
            <i class="bi" [class.bi-plus-circle-fill]="isCreateMode()" [class.bi-pencil-square]="!isCreateMode()"></i>
            {{ isCreateMode() ? 'Formulario de Ingreso - PQRS' : 'Formulario de Actualización - PQRS / Gestión RCV' }}
          </span>
          <a routerLink="/pqrs/lista" class="btn btn-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Cancelar
          </a>
        </div>

        <!-- Alert messages -->
        <div *ngIf="alertMessage()" class="alert alert-success">
          <i class="bi bi-check-circle-fill"></i>
          <span>{{ alertMessage() }}</span>
        </div>

        <!-- MODE: CREATE NEW PQRS -->
        <form *ngIf="isCreateMode()" (ngSubmit)="onCreateSubmit()" #createForm="ngForm">
          <div class="form-grid">
            <div class="form-group">
              <label class="form-label">Fecha Radicación <span class="required">*</span></label>
              <input type="date" class="form-control" name="fecha_rad" [(ngModel)]="newRecord.fecha_rad" required>
            </div>
            
            <div class="form-group">
              <label class="form-label">Fecha Envío Gestión</label>
              <input type="date" class="form-control" name="fecha_envio_ges" [(ngModel)]="newRecord.fecha_envio_ges">
            </div>

            <div class="form-group">
              <label class="form-label">Tipo ID <span class="required">*</span></label>
              <select class="form-control" name="tipo_id" [(ngModel)]="newRecord.tipo_id" required>
                <option value="CC">Cédula de Ciudadanía (CC)</option>
                <option value="TI">Tarjeta de Identidad (TI)</option>
                <option value="CE">Cédula de Extranjería (CE)</option>
                <option value="RC">Registro Civil (RC)</option>
                <option value="PA">Pasaporte (PA)</option>
              </select>
            </div>

            <div class="form-group">
              <label class="form-label">Documento ID <span class="required">*</span></label>
              <input type="text" class="form-control" name="docto_id" [(ngModel)]="newRecord.docto_id" required placeholder="Número de documento">
            </div>
          </div>

          <div class="form-grid">
            <div class="form-group col-span-2">
              <label class="form-label">Nombres Completos <span class="required">*</span></label>
              <input type="text" class="form-control" name="nombres" [(ngModel)]="newRecord.nombres" required placeholder="Nombres y Apellidos del paciente">
            </div>

            <div class="form-group">
              <label class="form-label">Ciudad <span class="required">*</span></label>
              <input type="text" class="form-control" name="ciudad" [(ngModel)]="newRecord.ciudad" required placeholder="Ej. PASTO">
            </div>

            <div class="form-group">
              <label class="form-label">Departamento <span class="required">*</span></label>
              <input type="text" class="form-control" name="departamento" [(ngModel)]="newRecord.departamento" required placeholder="Ej. NARIÑO">
            </div>
          </div>

          <div class="form-grid">
            <div class="form-group">
              <label class="form-label">Tipo Solicitud <span class="required">*</span></label>
              <select class="form-control" name="tipo" [(ngModel)]="newRecord.tipo" required>
                <option value="PETICION">Petición</option>
                <option value="QUEJA">Queja</option>
                <option value="RECLAMO">Reclamo</option>
                <option value="SUGERENCIA">Sugerencia</option>
              </select>
            </div>

            <div class="form-group">
              <label class="form-label">Régimen <span class="required">*</span></label>
              <select class="form-control" name="plan" [(ngModel)]="newRecord.plan" required>
                <option value="CONTRIBUTIVO">Contributivo</option>
                <option value="SUBSIDIADO">Subsidiado</option>
              </select>
            </div>

            <div class="form-group col-span-2">
              <label class="form-label">IPS Destino <span class="required">*</span></label>
              <input type="text" class="form-control" name="ips" [(ngModel)]="newRecord.ips" required placeholder="Nombre de la IPS prestadora">
            </div>
          </div>

          <div class="form-grid">
            <div class="form-group col-span-2">
              <label class="form-label">Motivo Principal <span class="required">*</span></label>
              <input type="text" class="form-control" name="motivo" [(ngModel)]="newRecord.motivo" required placeholder="Ej. Reclamación de pagos acumulados">
            </div>

            <div class="form-group">
              <label class="form-label">Diagnóstico CIE-10</label>
              <input type="text" class="form-control" name="diagnostico" [(ngModel)]="newRecord.diagnostico" placeholder="Ej. G40.9">
            </div>

            <div class="form-group">
              <label class="form-label">Fecha Vencimiento <span class="required">*</span></label>
              <input type="date" class="form-control" name="fecha_venc" [(ngModel)]="newRecord.fecha_venc" required>
            </div>
          </div>

          <div class="form-group">
            <label class="form-label">Observaciones Iniciales / Especificación <span class="required">*</span></label>
            <textarea class="form-control" name="observaciones" rows="4" [(ngModel)]="newRecord.observaciones" required placeholder="Describa a detalle la solicitud..."></textarea>
          </div>

          <div class="form-actions mt-4">
            <button type="submit" class="btn btn-primary" [disabled]="!createForm.form.valid">
              <i class="bi bi-plus-circle"></i> REGISTRAR CASO
            </button>
            <button type="reset" class="btn btn-secondary">
              <i class="bi bi-eraser"></i> Limpiar Formulario
            </button>
          </div>
        </form>

        <!-- MODE: UPDATE EXISTING PQRS (RCV fields) -->
        <div *ngIf="!isCreateMode() && existingRecord()" class="edit-mode-layout">
          <!-- Read-only Summary Table of Original Data -->
          <div class="readonly-summary">
            <h4>Resumen del Caso Radicado</h4>
            <div class="summary-table">
              <div class="sum-row">
                <span class="sum-lbl">Fecha Radicado</span><span class="sum-val">{{ existingRecord()?.fecha_rad }}</span>
                <span class="sum-lbl">Fecha Envio Gestión</span><span class="sum-val">{{ existingRecord()?.fecha_envio_ges }}</span>
              </div>
              <div class="sum-row">
                <span class="sum-lbl">Identificación</span><span class="sum-val">{{ existingRecord()?.tipo_id }} {{ existingRecord()?.docto_id }}</span>
                <span class="sum-lbl">Código Registro</span><span class="sum-val">{{ existingRecord()?.cod_registro }}</span>
              </div>
              <div class="sum-row">
                <span class="sum-lbl">Nombres Completos</span><span class="sum-val highlight">{{ existingRecord()?.nombres }}</span>
                <span class="sum-lbl">IPS Destino</span><span class="sum-val">{{ existingRecord()?.ips }}</span>
              </div>
              <div class="sum-row">
                <span class="sum-lbl">Tipo Solicitud</span><span class="sum-val"><span class="badge badge-primary">{{ existingRecord()?.tipo }}</span></span>
                <span class="sum-lbl">Motivo Principal</span><span class="sum-val">{{ existingRecord()?.motivo }}</span>
              </div>
              <div class="sum-row">
                <span class="sum-lbl">Observaciones</span>
                <span class="sum-val block-val col-span-3">{{ existingRecord()?.observaciones }}</span>
              </div>
            </div>
          </div>

          <hr class="divider" />

          <!-- Editable RCV Form -->
          <form (ngSubmit)="onUpdateSubmit()" #updateForm="ngForm" class="update-form">
            <h4 class="form-section-title"><i class="bi bi-file-earmark-diff"></i> Actualización de Gestión de Cartera RCV</h4>
            
            <div class="form-grid mt-4">
              <div class="form-group">
                <label class="form-label">Responsable Gestión <span class="required">*</span></label>
                <select class="form-control" name="responsable_ges" [(ngModel)]="editFields.responsable_ges" required>
                  <option value="SILVIA BASTIDAS">SILVIA BASTIDAS</option>
                  <option value="VANESSA MORENO">VANESSA MORENO</option>
                  <option value="LADY SF">LADY SF</option>
                  <option value="VERONICA LOBRIDO">VERONICA LOBRIDO</option>
                  <option value="VIVIAN V.">VIVIAN V.</option>
                  <option value="YURI M.">YURI M.</option>
                  <option value="JESSICA A.">JESSICA A.</option>
                  <option value="MILENA A.">MILENA A.</option>
                </select>
              </div>

              <div class="form-group">
                <label class="form-label">Fecha de Envío</label>
                <input type="date" class="form-control" name="fecha_envio" [(ngModel)]="editFields.fecha_envio">
              </div>

              <div class="form-group">
                <label class="form-label">Estado de Gestión <span class="required">*</span></label>
                <select class="form-control" name="estado" [(ngModel)]="editFields.estado" required>
                  <option value="ABIERTO">ABIERTO</option>
                  <option value="EN PROCESO">EN PROCESO</option>
                  <option value="CERRADO">CERRADO</option>
                </select>
              </div>
            </div>

            <div class="form-grid">
              <div class="form-group col-span-2">
                <label class="form-label">Observación de Gestión RCV</label>
                <input type="text" class="form-control" name="observacion" [(ngModel)]="editFields.observacion" placeholder="Detalles de la gestión de cartera...">
              </div>

              <div class="form-group col-span-2">
                <label class="form-label">Observación Final PQRS</label>
                <input type="text" class="form-control" name="observ_pqrs" [(ngModel)]="editFields.observ_pqrs" placeholder="Observaciones finales del caso...">
              </div>
            </div>

            <div class="form-actions mt-6">
              <button type="submit" class="btn btn-success" [disabled]="!updateForm.form.valid">
                <i class="bi bi-check-circle"></i> ACEPTAR CAMBIOS
              </button>
              <a [routerLink]="['/pqrs/visualizar', existingRecord()?.id]" class="btn btn-secondary">
                <i class="bi bi-eye"></i> Ver Ficha
              </a>
            </div>
          </form>
        </div>

      </div>
    </div>
  `,
  styles: [`
    .pqrs-form-container {
      display: flex;
      flex-direction: column;
      gap: 20px;
    }

    .required {
      color: var(--danger-color);
    }

    .form-actions {
      display: flex;
      gap: 12px;
      justify-content: flex-end;
      border-top: 1px solid var(--neutral-200);
      padding-top: 20px;
    }

    .form-group.col-span-2 {
      grid-column: span 2;
    }

    .divider {
      border: none;
      height: 1px;
      background-color: var(--neutral-200);
      margin: 24px 0;
    }

    .form-section-title {
      font-size: 1rem;
      color: var(--primary-color);
      font-weight: 600;
      border-left: 4px solid var(--primary-color);
      padding-left: 8px;
    }

    /* Summary Table styling */
    .readonly-summary h4 {
      font-size: 0.9rem;
      text-transform: uppercase;
      color: var(--neutral-500);
      margin-bottom: 12px;
      font-weight: 700;
    }

    .summary-table {
      border: 1px solid var(--neutral-200);
      border-radius: var(--border-radius-sm);
      overflow: hidden;
      background-color: var(--neutral-50);
    }

    .sum-row {
      display: grid;
      grid-template-columns: 1fr 2fr 1fr 2fr;
      border-bottom: 1px solid var(--neutral-200);
      font-size: 0.85rem;
    }

    .sum-row:last-child {
      border-bottom: none;
    }

    .sum-lbl {
      background-color: var(--neutral-100);
      color: var(--neutral-600);
      font-weight: 600;
      padding: 10px 14px;
      border-right: 1px solid var(--neutral-200);
    }

    .sum-val {
      padding: 10px 14px;
      color: var(--neutral-800);
      border-right: 1px solid var(--neutral-200);
    }

    .sum-val:last-child {
      border-right: none;
    }

    .sum-val.highlight {
      font-weight: 600;
      color: var(--primary-dark);
    }

    .sum-val.block-val {
      line-height: 1.5;
      font-style: italic;
    }

    .col-span-3 {
      grid-column: span 3;
    }

    .mt-6 {
      margin-top: 24px;
    }

    @media (max-width: 768px) {
      .form-grid {
        grid-template-columns: 1fr;
      }
      .form-group.col-span-2 {
        grid-column: span 1;
      }
      .sum-row {
        grid-template-columns: 1fr 1.5fr;
      }
      .sum-lbl, .sum-val {
        border-right: none;
        border-bottom: 1px solid var(--neutral-200);
      }
      .sum-row .col-span-3 {
        grid-column: span 1;
      }
    }
  `]
})
export class PqrsFormComponent implements OnInit {
  isCreateMode = signal(true);
  existingRecord = signal<PqrsRecord | undefined>(undefined);
  alertMessage = signal<string | null>(null);

  // Form states
  newRecord = {
    fecha_rad: new Date().toISOString().split('T')[0],
    fecha_envio_ges: new Date().toISOString().split('T')[0],
    tipo_id: 'CC',
    docto_id: '',
    nombres: '',
    ciudad: '',
    departamento: '',
    tipo: 'PETICION',
    plan: 'CONTRIBUTIVO',
    ips: '',
    motivo: '',
    diagnostico: '',
    fecha_venc: '',
    observaciones: ''
  };

  editFields = {
    responsable_ges: 'SILVIA BASTIDAS',
    observacion: '',
    fecha_envio: '',
    estado: 'ABIERTO',
    observ_pqrs: ''
  };

  constructor(
    private route: ActivatedRoute,
    private router: Router,
    private mockService: MockDataService
  ) {}

  ngOnInit(): void {
    const routePath = this.route.snapshot.url[0]?.path;
    this.isCreateMode.set(routePath === 'crear');

    if (!this.isCreateMode()) {
      const idParam = this.route.snapshot.paramMap.get('id');
      if (idParam) {
        const id = parseInt(idParam, 10);
        const record = this.mockService.getPqrsById(id);
        if (record) {
          this.existingRecord.set(record);
          this.editFields = {
            responsable_ges: record.responsable_ges || 'SILVIA BASTIDAS',
            observacion: record.observacion || '',
            fecha_envio: record.fecha_envio || '',
            estado: record.estado || 'ABIERTO',
            observ_pqrs: record.observ_pqrs || ''
          };
        } else {
          this.router.navigate(['/pqrs/lista']);
        }
      }
    }
  }

  onCreateSubmit(): void {
    this.mockService.createPqrs(this.newRecord);
    this.alertMessage.set('La PQRS fue registrada satisfactoriamente en la base de datos.');
    setTimeout(() => {
      this.alertMessage.set(null);
      this.router.navigate(['/pqrs/lista']);
    }, 2000);
  }

  onUpdateSubmit(): void {
    const record = this.existingRecord();
    if (record) {
      this.mockService.updatePqrs(record.id, this.editFields);
      this.alertMessage.set('La PQRS fue actualizada satisfactoriamente en el sistema.');
      setTimeout(() => {
        this.alertMessage.set(null);
        this.router.navigate(['/pqrs/lista']);
      }, 2000);
    }
  }
}
