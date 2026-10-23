import { Injectable, signal, computed, inject } from '@angular/core';
import { Router } from '@angular/router';
import { KeycloakService } from './keycloak.service';

export interface UserSession {
  username: string;
  name: string;
  email?: string;
  role: number; // 1 = Tesoreria Admin, 2 = PQRS Gestor, 0 = Sin acceso
  roles?: string[];
  empId?: string;
  noId?: string;
}

@Injectable({
  providedIn: 'root'
})
export class AuthService {
  private readonly SESSION_KEY = 'sagem_user_session';
  private router = inject(Router);
  private keycloakService = inject(KeycloakService);

  // Reactive session state using signals
  private sessionState = signal<UserSession | null>(this.loadSessionFromStorage());

  public readonly currentUser = computed(() => this.sessionState());
  public readonly isAuthenticated = computed(() => this.sessionState() !== null);
  public readonly userRole = computed(() => this.sessionState()?.role ?? null);

  /**
   * Valida si el usuario actual cuenta específicamente con el rol 'sagem-tesoreria'
   */
  public readonly hasTesoreriaRole = computed(() => {
    if (this.keycloakService.isLoggedIn()) {
      return this.keycloakService.hasRole('sagem-tesoreria');
    }
    const session = this.sessionState();
    if (!session) return false;
    return session.roles?.some(r => r.trim().toLowerCase() === 'sagem-tesoreria') ?? false;
  });

  constructor() {
    if (this.keycloakService.isLoggedIn()) {
      this.syncFromKeycloak();
    }
  }

  private loadSessionFromStorage(): UserSession | null {
    try {
      const data = localStorage.getItem(this.SESSION_KEY);
      return data ? JSON.parse(data) : null;
    } catch {
      return null;
    }
  }

  /**
   * Sincroniza la sesión del usuario a partir del token y perfil de Keycloak
   */
  public syncFromKeycloak(): boolean {
    if (!this.keycloakService.isLoggedIn()) {
      return false;
    }

    const tokenParsed: any = this.keycloakService.getTokenParsed();
    const profile = this.keycloakService.userProfile();
    const roles = this.keycloakService.getUserRoles();

    // Extraer nombres y atributos de Emssanar
    const username = tokenParsed?.preferred_username || profile?.username || 'usuario';
    const fullName = tokenParsed?.name || 
      `${profile?.firstName || ''} ${profile?.lastName || ''}`.trim() || 
      tokenParsed?.given_name || 
      username;

    const email = tokenParsed?.email || profile?.email || '';
    const noId = tokenParsed?.numero_identificacion || 
                 tokenParsed?.cedula || 
                 tokenParsed?.nit || 
                 tokenParsed?.sub || '';

    // Validar rol estricto: para visualizar este módulo DEBE tener el rol 'sagem-tesoreria'
    const hasSagemTesoreria = this.keycloakService.hasRole('sagem-tesoreria');
    
    // Si no tiene sagem-tesoreria, role = 0 (sin acceso al módulo)
    let role = 0;
    if (hasSagemTesoreria) {
      role = 1; // Acceso concedido al módulo de Tesorería SAGEM
    }

    const session: UserSession = {
      username,
      name: fullName,
      email,
      role,
      roles,
      noId,
      empId: tokenParsed?.empId || ''
    };

    this.sessionState.set(session);
    localStorage.setItem(this.SESSION_KEY, JSON.stringify(session));
    return true;
  }

  public hasRole(roleName: string): boolean {
    if (this.keycloakService.isLoggedIn()) {
      return this.keycloakService.hasRole(roleName);
    }
    const session = this.sessionState();
    if (!session) return false;
    return session.roles?.some(r => r.trim().toLowerCase() === roleName.trim().toLowerCase()) ?? false;
  }

  public loginWithKeycloak(): Promise<void> {
    return this.keycloakService.login();
  }

  public login(user: string, pass: string): boolean {
    const username = user.trim().toLowerCase();
    
    // Simulación de cuentas para pruebas locales
    let session: UserSession | null = null;
    
    if (username === 'admin' && pass === '123456') {
      session = {
        username: 'admin',
        name: 'Administrador de Tesorería',
        role: 1,
        roles: ['sagem-tesoreria'], // Incluye el rol requerido
        empId: 'EMP001',
        noId: '101010'
      };
    } else if (username === 'pqrs' && pass === '123456') {
      session = {
        username: 'pqrs',
        name: 'Gestor de PQRS',
        role: 0,
        roles: ['sagem-pqrs'], // No cuenta con sagem-tesoreria
        empId: 'EMP002',
        noId: '202020'
      };
    }

    if (session) {
      this.sessionState.set(session);
      localStorage.setItem(this.SESSION_KEY, JSON.stringify(session));
      return true;
    }
    
    return false;
  }

  public logout(): void {
    this.sessionState.set(null);
    localStorage.removeItem(this.SESSION_KEY);
    if (this.keycloakService.isLoggedIn()) {
      this.keycloakService.logout({ redirectUri: window.location.origin });
    } else {
      this.router.navigate(['/login']);
    }
  }

  public recuperarClave(noId: string): string | null {
    if (noId === '101010') {
      return 'bryanacosta@emssanar.org.co';
    } else if (noId === '202020') {
      return 'pqrs@emssanar.org.co';
    }
    return null;
  }
}
