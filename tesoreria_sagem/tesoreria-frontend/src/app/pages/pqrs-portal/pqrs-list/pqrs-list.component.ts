import { Component, signal, computed } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { RouterLink } from '@angular/router';
import { MockDataService, PqrsRecord } from '../../../services/mock-data.service';

@Component({
  selector: 'app-pqrs-list',
  standalone: true,
  imports: [CommonModule, FormsModule, RouterLink],
  template: `
    <div class="pqrs-list-container animate-fade-in">
      <div class="card">
        <div class="card-title">
          <span><i class="bi bi-chat-square-text-fill"></i> Bandeja de Casos - Gestión de PQRS</span>
          <a routerLink="/pqrs/crear" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-circle"></i> Nuevo Caso
          </a>
        </div>

        <!-- Search / Filter bar -->
        <div class="search-bar">
          <div class="form-grid">
            <div class="form-group">
              <label class="form-label">Buscar Caso</label>
              <div class="input-wrapper">
                <i class="bi bi-search input-icon"></i>
                <input 
                  type="text" 
                  class="form-control pl-8" 
                  placeholder="ID, Documento, Nombres o IPS..." 
                  [(ngModel)]="searchQuery">
              </div>
            </div>

            <div class="form-group">
              <label class="form-label">Filtrar por Estado</label>
              <select class="form-control" [(ngModel)]="statusFilter">
                <option value="">Todos los Estados</option>
                <option value="ABIERTO">Abierto</option>
                <option value="EN PROCESO">En Proceso</option>
                <option value="CERRADO">Cerrado</option>
              </select>
            </div>
          </div>
        </div>

        <!-- PQRS Grid Table -->
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th>ID</th>
                <th>Radicado</th>
                <th>Documento</th>
                <th>Nombre Solicitante</th>
                <th>Tipo</th>
                <th>IPS Destino</th>
                <th>Responsable</th>
                <th>Estado</th>
                <th class="text-center">Acciones</th>
              </tr>
            </thead>
            <tbody>
              <tr *ngFor="let item of filteredPqrs()">
                <td><span class="font-semibold">{{ item.id }}</span></td>
                <td>{{ item.fecha_rad }}</td>
                <td>{{ item.tipo_id }} {{ item.docto_id }}</td>
                <td>
                  <div class="name-col">
                    <span class="full-name">{{ item.nombres }}</span>
                    <span class="case-number">{{ item.no_caso }}</span>
                  </div>
                </td>
                <td><span class="badge badge-primary">{{ item.tipo }}</span></td>
                <td class="text-truncate" style="max-width: 160px;">{{ item.ips }}</td>
                <td>{{ item.responsable_ges || 'SIN ASIGNAR' }}</td>
                <td>
                  <span class="badge" [class]="getStatusClass(item.estado)">
                    {{ item.estado }}
                  </span>
                </td>
                <td>
                  <div class="actions-wrapper">
                    <a 
                      [routerLink]="['/pqrs/visualizar', item.id]" 
                      class="btn-icon-action view" 
                      title="Ver detalle de PQRS">
                      <i class="bi bi-file-earmark-medical"></i>
                    </a>
                    <a 
                      [routerLink]="['/pqrs/actualizar', item.id]" 
                      class="btn-icon-action edit" 
                      title="Modificar PQRS / RCV">
                      <i class="bi bi-pencil-square"></i>
                    </a>
                  </div>
                </td>
              </tr>
              <tr *ngIf="filteredPqrs().length === 0">
                <td colspan="9" class="text-center text-muted">No se encontraron casos registrados en la bandeja.</td>
              </tr>
            </tbody>
          </table>
        </div>

      </div>
    </div>
  `,
  styles: [`
    .pqrs-list-container {
      display: flex;
      flex-direction: column;
      gap: 20px;
    }

    .search-bar {
      margin-bottom: 20px;
      background-color: var(--neutral-100);
      padding: 16px;
      border-radius: var(--border-radius-sm);
    }

    .input-wrapper {
      position: relative;
    }

    .input-icon {
      position: absolute;
      left: 12px;
      top: 50%;
      transform: translateY(-50%);
      color: var(--neutral-400);
    }

    .pl-8 {
      padding-left: 36px;
    }

    .font-semibold {
      font-weight: 600;
      color: var(--neutral-800);
    }

    .name-col {
      display: flex;
      flex-direction: column;
    }

    .full-name {
      font-weight: 500;
      color: var(--neutral-800);
    }

    .case-number {
      font-size: 0.75rem;
      color: var(--neutral-400);
    }

    .text-center {
      text-align: center;
    }

    .text-muted {
      color: var(--neutral-400);
      padding: 24px;
    }

    .text-truncate {
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
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
      text-decoration: none;
      display: inline-flex;
    }

    .btn-icon-action.view {
      color: var(--success-color);
    }
    .btn-icon-action.view:hover {
      background-color: var(--success-light);
    }

    .btn-icon-action.edit {
      color: var(--primary-color);
    }
    .btn-icon-action.edit:hover {
      background-color: var(--primary-light);
    }
  `]
})
export class PqrsListComponent {
  searchQuery = '';
  statusFilter = '';

  constructor(private mockService: MockDataService) {}

  filteredPqrs = computed(() => {
    const list = this.mockService.getPqrsList();
    const query = this.searchQuery.trim().toLowerCase();
    const state = this.statusFilter;

    return list.filter(item => {
      // Apply status filter
      if (state && item.estado !== state) return false;
      
      // Apply search query filter
      if (query) {
        return (
          item.id.toString().includes(query) ||
          item.docto_id.includes(query) ||
          item.nombres.toLowerCase().includes(query) ||
          item.ips.toLowerCase().includes(query) ||
          item.no_caso.toLowerCase().includes(query)
        );
      }
      
      return true;
    });
  });

  getStatusClass(status: string): string {
    const s = status.toUpperCase();
    if (s === 'ABIERTO') return 'badge-warning';
    if (s === 'EN PROCESO') return 'badge-primary';
    if (s === 'CERRADO') return 'badge-success';
    return 'badge-secondary';
  }
}
