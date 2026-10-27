import { Component, signal, computed, inject } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterLink } from '@angular/router';
import { MockDataService } from '../../services/mock-data.service';
import { AuthService } from '../../services/auth.service';

@Component({
  selector: 'app-admin-inicio',
  standalone: true,
  imports: [CommonModule, RouterLink],
  template: `
    <div class="welcome-container animate-fade-in">
      
      <!-- Banner -->
      <div class="welcome-banner">
        <div class="banner-content">
          <h1>¡Bienvenido al Portal de Tesorería, {{ user()?.name }}!</h1>
          <p>Esta herramienta digital permite gestionar conciliaciones, realizar consultas rápidas de cartera, impuestos, pagos y la circular 030 de manera ágil y centralizada.</p>
        </div>
        <div class="banner-graphic">
          <i class="bi bi-person-workspace"></i>
        </div>
      </div>

      <!-- Quick Metrics Cards -->
      <div class="metrics-grid">
        <div class="metric-card">
          <div class="metric-icon primary">
            <i class="bi bi-envelope-check-fill"></i>
          </div>
          <div class="metric-details">
            <h3>{{ totalEmails() }}</h3>
            <p>Proveedores Registrados</p>
          </div>
        </div>

        <div class="metric-card">
          <div class="metric-icon success">
            <i class="bi bi-chat-right-text-fill"></i>
          </div>
          <div class="metric-details">
            <h3>{{ openPqrs() }}</h3>
            <p>Casos PQRS Activos</p>
          </div>
        </div>

        <div class="metric-card">
          <div class="metric-icon warning">
            <i class="bi bi-file-earmark-spreadsheet-fill"></i>
          </div>
          <div class="metric-details">
            <h3>14</h3>
            <p>Formatos de Reportes</p>
          </div>
        </div>

        <div class="metric-card">
          <div class="metric-icon danger">
            <i class="bi bi-clock-history"></i>
          </div>
          <div class="metric-details">
            <h3>20 min</h3>
            <p>Tiempo Límite Sesión</p>
          </div>
        </div>
      </div>

      <!-- Quick Shortcuts -->
      <div class="shortcuts-section">
        <h3>Accesos Directos Frecuentes</h3>
        <div class="shortcuts-grid">
          <a routerLink="/admin/recobros/nit-cuenta" class="shortcut-item">
            <i class="bi bi-shield-check icon"></i>
            <h4>Recobros</h4>
            <p>Consulta pagos por NIT y cuenta de cobro</p>
          </a>

          <a routerLink="/admin/cartera/nit-periodo" class="shortcut-item">
            <i class="bi bi-folder-check icon"></i>
            <h4>Cartera</h4>
            <p>Consulta estados de cartera por periodos de facturación</p>
          </a>

          <a routerLink="/admin/tesoreria/nit-documento" class="shortcut-item">
            <i class="bi bi-cash-coin icon"></i>
            <h4>Tesorería</h4>
            <p>Consulta pagos emitidos por NIT y documento de egreso</p>
          </a>

          <a routerLink="/admin/impuestos/nit-periodo" class="shortcut-item">
            <i class="bi bi-receipt icon"></i>
            <h4>Impuestos</h4>
            <p>Consulta retenciones e impuestos por NIT y periodo</p>
          </a>

          <a routerLink="/admin/emails" class="shortcut-item">
            <i class="bi bi-envelope-at icon"></i>
            <h4>Emails Proveedores</h4>
            <p>Administra correos autorizados para notificaciones</p>
          </a>
        </div>
      </div>

    </div>
  `,
  styles: [`
    .welcome-container {
      display: flex;
      flex-direction: column;
      gap: 24px;
    }

    .welcome-banner {
      background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
      color: white;
      border-radius: var(--border-radius-md);
      padding: 32px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: var(--shadow-md);
    }

    .banner-content h1 {
      color: white;
      font-size: 1.75rem;
      margin-bottom: 8px;
    }

    .banner-content p {
      font-size: 0.95rem;
      max-width: 650px;
      opacity: 0.9;
    }

    .banner-graphic {
      font-size: 4rem;
      opacity: 0.2;
      display: flex;
      align-items: center;
    }

    .metrics-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 20px;
    }

    .metric-card {
      background-color: white;
      border: 1px solid var(--neutral-200);
      border-radius: var(--border-radius-md);
      padding: 20px;
      display: flex;
      align-items: center;
      gap: 16px;
      box-shadow: var(--shadow-sm);
      transition: transform var(--transition-fast), box-shadow var(--transition-fast);
    }

    .metric-card:hover {
      transform: translateY(-2px);
      box-shadow: var(--shadow-md);
    }

    .metric-icon {
      width: 48px;
      height: 48px;
      border-radius: var(--border-radius-sm);
      display: flex;
      justify-content: center;
      align-items: center;
      font-size: 1.5rem;
    }

    .metric-icon.primary { background-color: var(--primary-light); color: var(--primary-color); }
    .metric-icon.success { background-color: var(--success-light); color: var(--success-color); }
    .metric-icon.warning { background-color: var(--warning-light); color: var(--warning-hover); }
    .metric-icon.danger { background-color: var(--danger-light); color: var(--danger-color); }

    .metric-details h3 {
      font-size: 1.5rem;
      font-weight: 700;
      color: var(--neutral-800);
      margin-bottom: 2px;
    }

    .metric-details p {
      font-size: 0.8rem;
      color: var(--neutral-500);
      text-transform: uppercase;
      font-weight: 600;
    }

    .shortcuts-section h3 {
      font-size: 1.2rem;
      color: var(--neutral-700);
      border-bottom: 2px solid var(--neutral-200);
      padding-bottom: 8px;
      margin-bottom: 16px;
    }

    .shortcuts-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
      gap: 20px;
    }

    .shortcut-item {
      background-color: white;
      border: 1px solid var(--neutral-200);
      border-radius: var(--border-radius-md);
      padding: 24px;
      text-align: center;
      text-decoration: none;
      color: inherit;
      transition: all var(--transition-normal);
      display: flex;
      flex-direction: column;
      align-items: center;
      box-shadow: var(--shadow-sm);
    }

    .shortcut-item:hover {
      border-color: var(--primary-color);
      transform: translateY(-4px);
      box-shadow: var(--shadow-lg);
    }

    .shortcut-item .icon {
      font-size: 2.25rem;
      color: var(--primary-color);
      margin-bottom: 12px;
    }

    .shortcut-item h4 {
      font-size: 1rem;
      margin-bottom: 6px;
      color: var(--neutral-800);
    }

    .shortcut-item p {
      font-size: 0.8rem;
      color: var(--neutral-500);
    }
  `]
})
export class AdminInicioComponent {
  private authService = inject(AuthService);
  private mockService = inject(MockDataService);

  user = this.authService.currentUser;
  
  totalEmails = computed(() => this.mockService.getEmails().length);
  openPqrs = computed(() => this.mockService.getPqrsList().filter(p => p.estado !== 'CERRADO').length);

  constructor() {}
}
