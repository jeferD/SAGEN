import { Component, signal, computed } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { MockDataService, EmailRecord } from '../../services/mock-data.service';

@Component({
  selector: 'app-emails-crud',
  standalone: true,
  imports: [CommonModule, FormsModule],
  template: `
    <div class="emails-container animate-fade-in">
      <div class="row-layout">
        
        <!-- Left Panel: Emails list -->
        <div class="list-panel card">
          <div class="card-title">
            <span><i class="bi bi-envelope-at-fill"></i> Directorio de Correos - Prestadores</span>
            <button class="btn btn-success btn-sm" (click)="onDownloadAll()">
              <i class="bi bi-cloud-arrow-down"></i> Exportar
            </button>
          </div>

          <!-- Search filter -->
          <div class="search-box">
            <div class="input-wrapper">
              <i class="bi bi-search search-icon"></i>
              <input 
                type="text" 
                class="form-control" 
                placeholder="Buscar por NIT o Nombre..." 
                [(ngModel)]="searchQuery">
            </div>
          </div>

          <!-- List Table -->
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th>NIT</th>
                  <th>Nombre Prestador</th>
                  <th>Correo Electrónico</th>
                  <th class="text-center">Acciones</th>
                </tr>
              </thead>
              <tbody>
                <tr *ngFor="let item of filteredEmails()">
                  <td>{{ item.nit }}</td>
                  <td class="font-medium">{{ item.nombre }}</td>
                  <td>{{ item.email }}</td>
                  <td>
                    <div class="actions-wrapper">
                      <button 
                        class="btn-icon-action edit" 
                        title="Editar correo" 
                        (click)="onEditSelect(item)">
                        <i class="bi bi-pencil-square"></i>
                      </button>
                      <button 
                        class="btn-icon-action delete" 
                        title="Eliminar prestador" 
                        (click)="onDeleteConfirm(item)">
                        <i class="bi bi-trash3"></i>
                      </button>
                    </div>
                  </td>
                </tr>
                <tr *ngIf="filteredEmails().length === 0">
                  <td colspan="4" class="text-center text-muted">No se encontraron prestadores registrados.</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <!-- Right Panel: Create/Update form -->
        <div class="form-panel card">
          <div class="card-title">
            <span>
              <i class="bi" [class.bi-plus-circle-fill]="!isEditMode()" [class.bi-pencil-fill]="isEditMode()"></i> 
              {{ isEditMode() ? 'Actualizar Correo' : 'Registrar Prestador' }}
            </span>
            <button *ngIf="isEditMode()" class="btn btn-secondary btn-sm" (click)="cancelEdit()">Cancelar</button>
          </div>

          <!-- Alert feedback -->
          <div *ngIf="alertMessage()" class="alert alert-success">
            <i class="bi bi-check-circle-fill"></i>
            <span>{{ alertMessage() }}</span>
          </div>

          <form (ngSubmit)="onSubmit()" #emailForm="ngForm">
            <div class="form-group">
              <label class="form-label">NIT <span class="required">*</span></label>
              <input 
                type="text" 
                class="form-control" 
                name="nit" 
                [(ngModel)]="formData.nit" 
                required 
                [readonly]="isEditMode()" 
                placeholder="Ej. 900123456">
            </div>

            <div class="form-group">
              <label class="form-label">Nombre del Prestador / IPS <span class="required">*</span></label>
              <input 
                type="text" 
                class="form-control" 
                name="nombre" 
                [(ngModel)]="formData.nombre" 
                required 
                [readonly]="isEditMode()" 
                placeholder="Ej. CLINICA VALLE DEL LILI">
            </div>

            <div class="form-group">
              <label class="form-label">Correo Electrónico <span class="required">*</span></label>
              <input 
                type="email" 
                class="form-control" 
                name="email" 
                [(ngModel)]="formData.email" 
                required 
                placeholder="Ej. facturacion@ips.com">
            </div>

            <button 
              type="submit" 
              class="btn w-full mt-4" 
              [class.btn-primary]="!isEditMode()"
              [class.btn-success]="isEditMode()"
              [disabled]="!emailForm.form.valid">
              <i class="bi" [class.bi-plus-circle]="!isEditMode()" [class.bi-check-circle]="isEditMode()"></i> 
              {{ isEditMode() ? 'ACEPTAR CAMBIOS' : 'REGISTRAR' }}
            </button>
          </form>
        </div>

      </div>
    </div>
  `,
  styles: [`
    .emails-container {
      display: flex;
      flex-direction: column;
      gap: 20px;
    }

    .row-layout {
      display: flex;
      gap: 24px;
      flex-wrap: wrap;
    }

    .list-panel {
      flex: 3;
      min-width: 600px;
    }

    .form-panel {
      flex: 1.5;
      min-width: 320px;
      height: fit-content;
      position: sticky;
      top: 90px;
    }

    .search-box {
      margin-bottom: 16px;
    }

    .search-box .input-wrapper {
      position: relative;
    }

    .search-icon {
      position: absolute;
      left: 12px;
      top: 50%;
      transform: translateY(-50%);
      color: var(--neutral-400);
    }

    .search-box .form-control {
      padding-left: 36px;
    }

    .font-medium {
      font-weight: 500;
      color: var(--neutral-800);
    }

    .text-center {
      text-align: center;
    }

    .text-muted {
      color: var(--neutral-400);
      padding: 24px;
    }

    .actions-wrapper {
      display: flex;
      gap: 8px;
      justify-content: center;
    }

    .btn-icon-action {
      background: none;
      border: none;
      font-size: 1.1rem;
      cursor: pointer;
      padding: 6px;
      border-radius: 4px;
      transition: all var(--transition-fast);
    }

    .btn-icon-action.edit {
      color: var(--primary-color);
    }
    .btn-icon-action.edit:hover {
      background-color: var(--primary-light);
    }

    .btn-icon-action.delete {
      color: var(--danger-color);
    }
    .btn-icon-action.delete:hover {
      background-color: var(--danger-light);
    }

    .required {
      color: var(--danger-color);
    }

    .w-full {
      width: 100%;
    }

    .mt-4 {
      margin-top: 16px;
    }

    @media (max-width: 1024px) {
      .list-panel, .form-panel {
        flex: 1 1 100%;
        min-width: 100%;
      }
      .form-panel {
        position: static;
      }
    }
  `]
})
export class EmailsCrudComponent {
  searchQuery = '';
  isEditMode = signal(false);
  alertMessage = signal<string | null>(null);
  
  formData = {
    id: 0,
    nit: '',
    nombre: '',
    email: ''
  };

  constructor(private mockService: MockDataService) {}

  // Filter emails list reactively
  filteredEmails = computed(() => {
    const list = this.mockService.getEmails();
    const query = this.searchQuery.trim().toLowerCase();
    
    if (!query) return list;
    
    return list.filter(item => 
      item.nit.includes(query) || 
      item.nombre.toLowerCase().includes(query) ||
      item.email.toLowerCase().includes(query)
    );
  });

  onEditSelect(item: EmailRecord): void {
    this.isEditMode.set(true);
    this.formData = {
      id: item.id,
      nit: item.nit,
      nombre: item.nombre,
      email: item.email
    };
    this.alertMessage.set(null);
  }

  cancelEdit(): void {
    this.isEditMode.set(false);
    this.formData = { id: 0, nit: '', nombre: '', email: '' };
    this.alertMessage.set(null);
  }

  onDeleteConfirm(item: EmailRecord): void {
    if (confirm(`¿Está seguro de inactivar el correo de ${item.nombre}?`)) {
      this.mockService.deleteEmail(item.id);
      this.triggerAlert(`El correo de ${item.nombre} fue inactivado.`);
      if (this.formData.id === item.id) {
        this.cancelEdit();
      }
    }
  }

  onSubmit(): void {
    if (this.isEditMode()) {
      // Edit
      this.mockService.updateEmail(this.formData.id, this.formData.email);
      this.triggerAlert(`El correo de ${this.formData.nombre} fue actualizado satisfactoriamente.`);
      this.cancelEdit();
    } else {
      // Create
      this.mockService.createEmail(this.formData.nit, this.formData.nombre, this.formData.email);
      this.triggerAlert(`El correo fue registrado satisfactoriamente.`);
      this.formData = { id: 0, nit: '', nombre: '', email: '' };
    }
  }

  triggerAlert(message: string): void {
    this.alertMessage.set(message);
    setTimeout(() => this.alertMessage.set(null), 3000);
  }

  onDownloadAll(): void {
    const activeEmails = this.mockService.getEmails();
    const headers = ['NIT', 'NOMBRE IPS', 'EMAIL'];
    const rows = activeEmails.map(e => [e.nit, e.nombre, e.email]);
    this.mockService.downloadCsv('email.csv', headers, rows);
  }
}
