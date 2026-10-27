import { Component, signal, computed, inject } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterOutlet, RouterLink, RouterLinkActive } from '@angular/router';
import { AuthService } from '../../services/auth.service';

interface MenuItem {
  label: string;
  icon: string;
  route?: string;
  expanded?: boolean;
  subitems?: { label: string; icon: string; route: string }[];
}

@Component({
  selector: 'app-layout',
  standalone: true,
  imports: [CommonModule, RouterOutlet, RouterLink, RouterLinkActive],
  template: `
    <div class="app-container">
      <!-- Sidebar Navigation -->
      <aside class="app-sidebar" [class.collapsed]="isCollapsed()">
        <div class="sidebar-brand">
          <div class="brand-logo">
            <i class="bi bi-wallet2"></i>
          </div>
          <span class="brand-text" *ngIf="!isCollapsed()">SAGEM</span>
        </div>

        <nav class="sidebar-nav">
          <div *ngFor="let item of menuItems()" class="nav-item-wrapper">
            <!-- Normal Menu Item -->
            <a 
              *ngIf="!item.subitems" 
              [routerLink]="item.route" 
              routerLinkActive="active" 
              class="nav-link"
              [title]="item.label">
              <i class="nav-icon" [class]="item.icon"></i>
              <span class="nav-label" *ngIf="!isCollapsed()">{{ item.label }}</span>
            </a>

            <!-- Submenu Parent Item -->
            <div *ngIf="item.subitems" class="submenu-container">
              <button 
                (click)="toggleSubmenu(item)" 
                class="nav-link submenu-trigger"
                [class.open]="item.expanded"
                [title]="item.label">
                <i class="nav-icon" [class]="item.icon"></i>
                <span class="nav-label" *ngIf="!isCollapsed()">{{ item.label }}</span>
                <i class="bi bi-chevron-down submenu-arrow" *ngIf="!isCollapsed()"></i>
              </button>

              <!-- Collapsed Submenu -->
              <div 
                *ngIf="item.expanded && !isCollapsed()" 
                class="submenu-list animate-fade-in">
                <a 
                  *ngFor="let sub of item.subitems" 
                  [routerLink]="sub.route" 
                  routerLinkActive="active-sub"
                  class="submenu-link">
                  <i class="bi bi-chevron-right sub-icon"></i>
                  <span>{{ sub.label }}</span>
                </a>
              </div>
            </div>
          </div>
        </nav>
      </aside>

      <!-- Main Layout Body -->
      <div class="main-content" [class.collapsed]="isCollapsed()">
        <!-- Header -->
        <header class="app-header">
          <button class="toggle-sidebar-btn" (click)="toggleSidebar()">
            <i class="bi" [class.bi-list]="!isCollapsed()" [class.bi-arrow-right]=\"isCollapsed()\"></i>
          </button>
          
          <div class="header-title">
            <h3>Tesorería y Conciliación Sagem</h3>
          </div>

          <div class="header-user" *ngIf="currentUser()">
            <div class="user-info">
              <span class="user-name">{{ currentUser()?.name }}</span>
              <span class="user-role-tag" [class.text-danger]="!hasTesoreriaRole()">{{ hasTesoreriaRole() ? 'Tesorería Autorizada' : 'Sin rol sagem-tesoreria' }}</span>
            </div>
            <button class="btn btn-secondary btn-sm logout-btn" (click)="onLogout()">
              <i class="bi bi-box-arrow-right"></i> Salir
            </button>
          </div>
        </header>

        <!-- Main Workspace -->
        <main class="content-body">
          <router-outlet *ngIf="hasTesoreriaRole()"></router-outlet>
          <div *ngIf="!hasTesoreriaRole()" class="no-role-warning animate-fade-in">
            <div class="no-role-box">
              <i class="bi bi-shield-x warning-icon"></i>
              <h4>Módulo Restringido</h4>
              <p>Para visualizar este módulo debe contar con el rol <strong>sagem-tesoreria</strong> en su token de acceso.</p>
              <button class="btn btn-secondary btn-sm" (click)="onLogout()">
                <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
              </button>
            </div>
          </div>
        </main>

        <!-- Footer -->
        <footer class="app-footer">
          <p>© 2026 Emssanar EPS</p>
        </footer>
      </div>
    </div>
  `,
  styles: [`
    .app-sidebar {
      position: fixed;
      left: 0;
      top: 0;
      bottom: 0;
      width: var(--sidebar-width);
      background-color: var(--neutral-900);
      color: var(--neutral-300);
      display: flex;
      flex-direction: column;
      box-shadow: var(--shadow-lg);
      z-index: 100;
      transition: width var(--transition-normal);
    }

    .app-sidebar.collapsed {
      width: var(--sidebar-collapsed-width);
    }

    .sidebar-brand {
      height: var(--header-height);
      display: flex;
      align-items: center;
      padding: 0 20px;
      gap: 12px;
      border-bottom: 1px solid var(--neutral-800);
      background-color: rgba(0, 0, 0, 0.2);
    }

    .brand-logo {
      width: 32px;
      height: 32px;
      background-color: var(--primary-color);
      border-radius: 6px;
      display: flex;
      justify-content: center;
      align-items: center;
      color: white;
      font-size: 18px;
    }

    .brand-text {
      font-weight: 700;
      font-size: 1.2rem;
      color: white;
      letter-spacing: 0.5px;
    }

    .sidebar-nav {
      flex: 1;
      padding: 16px 8px;
      overflow-y: auto;
      display: flex;
      flex-direction: column;
      gap: 4px;
    }

    .nav-link {
      display: flex;
      align-items: center;
      padding: 12px 14px;
      color: var(--neutral-400);
      text-decoration: none;
      border-radius: var(--border-radius-sm);
      font-weight: 500;
      transition: all var(--transition-fast);
      background: none;
      border: none;
      width: 100%;
      text-align: left;
      cursor: pointer;
    }

    .nav-link:hover {
      color: white;
      background-color: var(--neutral-800);
    }

    .nav-link.active {
      color: white;
      background-color: var(--primary-color);
      box-shadow: var(--shadow-md);
    }

    .nav-icon {
      font-size: 1.25rem;
      width: 24px;
      display: inline-block;
    }

    .nav-label {
      margin-left: 12px;
      font-size: 0.9rem;
      flex: 1;
    }

    .submenu-trigger {
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .submenu-arrow {
      font-size: 0.75rem;
      transition: transform var(--transition-fast);
    }

    .submenu-trigger.open .submenu-arrow {
      transform: rotate(180deg);
    }

    .submenu-list {
      background-color: rgba(0, 0, 0, 0.15);
      border-radius: var(--border-radius-sm);
      margin-top: 4px;
      padding: 4px 0;
      display: flex;
      flex-direction: column;
      gap: 2px;
    }

    .submenu-link {
      display: flex;
      align-items: center;
      padding: 8px 16px 8px 36px;
      color: var(--neutral-400);
      text-decoration: none;
      font-size: 0.85rem;
      border-radius: var(--border-radius-sm);
      transition: all var(--transition-fast);
    }

    .submenu-link:hover {
      color: white;
      background-color: var(--neutral-800);
    }

    .submenu-link.active-sub {
      color: var(--secondary-color);
      font-weight: 600;
    }

    .sub-icon {
      font-size: 0.65rem;
      margin-right: 8px;
    }

    /* Header */
    .app-header {
      height: var(--header-height);
      background-color: white;
      border-bottom: 1px solid var(--neutral-200);
      display: flex;
      align-items: center;
      padding: 0 24px;
      position: sticky;
      top: 0;
      z-index: 99;
      box-shadow: var(--shadow-sm);
    }

    .toggle-sidebar-btn {
      background: none;
      border: none;
      font-size: 1.5rem;
      color: var(--neutral-500);
      cursor: pointer;
      padding: 4px;
      border-radius: 4px;
      transition: background var(--transition-fast);
      margin-right: 16px;
    }

    .toggle-sidebar-btn:hover {
      background-color: var(--neutral-100);
      color: var(--neutral-800);
    }

    .header-title h3 {
      font-size: 1.15rem;
      color: var(--neutral-800);
      font-weight: 600;
    }

    .header-user {
      margin-left: auto;
      display: flex;
      align-items: center;
      gap: 16px;
    }

    .user-info {
      display: flex;
      flex-direction: column;
      text-align: right;
    }

    .user-name {
      font-weight: 600;
      color: var(--neutral-800);
      font-size: 0.9rem;
    }

    .user-role-tag {
      font-size: 0.75rem;
      color: var(--neutral-500);
      font-weight: 500;
    }

    .logout-btn {
      display: flex;
      align-items: center;
      gap: 6px;
    }

    /* Restricted Role State */
    .no-role-warning {
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: calc(100vh - var(--header-height) - 100px);
      padding: 32px;
    }

    .no-role-box {
      background: white;
      border: 1px solid #fee2e2;
      border-radius: 16px;
      padding: 36px 32px;
      text-align: center;
      max-width: 440px;
      box-shadow: 0 10px 25px rgba(239, 68, 68, 0.1);
    }

    .no-role-box .warning-icon {
      font-size: 48px;
      color: #ef4444;
      margin-bottom: 16px;
      display: inline-block;
    }

    .no-role-box h4 {
      font-size: 1.25rem;
      font-weight: 700;
      color: #1e293b;
      margin-bottom: 8px;
    }

    .no-role-box p {
      font-size: 0.85rem;
      color: #64748b;
      margin-bottom: 20px;
      line-height: 1.5;
    }

    .text-danger {
      color: #ef4444 !important;
      font-weight: 600;
    }
  `]
})
export class LayoutComponent {
  private authService = inject(AuthService);
  isCollapsed = signal(false);
  currentUser = this.authService.currentUser;
  hasTesoreriaRole = this.authService.hasTesoreriaRole;

  // Dynamically computed navigation menu: solo visible si cuenta con el rol sagem-tesoreria
  menuItems = computed<MenuItem[]>(() => {
    if (!this.hasTesoreriaRole()) {
      return []; // Si no tiene el rol sagem-tesoreria en el token, no visualiza nada
    }

    return [
      { label: 'Inicio', icon: 'bi bi-house-door', route: '/admin/inicio' },
      {
        label: 'Recobros',
        icon: 'bi bi-shield-check',
        expanded: false,
        subitems: [
          { label: 'Nit + Cuenta Cobro', icon: 'bi bi-search', route: '/admin/recobros/nit-cuenta' },
          { label: 'Nit + Factura', icon: 'bi bi-search', route: '/admin/recobros/nit-factura' },
          { label: 'Número de Radicado', icon: 'bi bi-search', route: '/admin/recobros/radicado' }
        ]
      },
      {
        label: 'Cartera',
        icon: 'bi bi-folder-check',
        expanded: false,
        subitems: [
          { label: 'Nit + Periodo', icon: 'bi bi-search', route: '/admin/cartera/nit-periodo' },
          { label: 'Nit + Cuenta Cobro', icon: 'bi bi-search', route: '/admin/cartera/nit-cuenta' },
          { label: 'Lista Radicados', icon: 'bi bi-search', route: '/admin/cartera/lista-radicados' }
        ]
      },
      {
        label: 'Tesorería',
        icon: 'bi bi-cash-coin',
        expanded: false,
        subitems: [
          { label: 'Nit + Periodo', icon: 'bi bi-search', route: '/admin/tesoreria/nit-periodo' },
          { label: 'Nit + Cuenta Cobro', icon: 'bi bi-search', route: '/admin/tesoreria/nit-cuenta' },
          { label: 'Nit + Documento', icon: 'bi bi-search', route: '/admin/tesoreria/nit-documento' },
          { label: 'Lista Radicados', icon: 'bi bi-search', route: '/admin/tesoreria/lista-radicados' }
        ]
      },
      {
        label: 'Impuestos',
        icon: 'bi bi-receipt',
        expanded: false,
        subitems: [
          { label: 'Nit + Periodo', icon: 'bi bi-search', route: '/admin/impuestos/nit-periodo' },
          { label: 'Nit + Cuenta Cobro', icon: 'bi bi-search', route: '/admin/impuestos/nit-cuenta' },
          { label: 'Nit + Documento', icon: 'bi bi-search', route: '/admin/impuestos/nit-documento' },
          { label: 'Lista Radicados', icon: 'bi bi-search', route: '/admin/impuestos/lista-radicados' }
        ]
      },
      {
        label: 'Circular 030',
        icon: 'bi bi-file-earmark-bar-graph',
        expanded: false,
        subitems: [
          { label: 'Fepa', icon: 'bi bi-stats', route: '/admin/circular030/fepa' },
          { label: 'Cruce', icon: 'bi bi-random', route: '/admin/circular030/cruce' }
        ]
      },
      {
        label: 'Emails Proveedores',
        icon: 'bi bi-envelope-at',
        route: '/admin/emails'
      }
    ];
  });

  constructor() { }

  toggleSidebar(): void {
    this.isCollapsed.set(!this.isCollapsed());
  }

  toggleSubmenu(item: MenuItem): void {
    item.expanded = !item.expanded;
  }

  onLogout(): void {
    this.authService.logout();
  }
}
