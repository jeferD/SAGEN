import { Injectable, signal, computed } from '@angular/core';
import Keycloak, { KeycloakProfile, KeycloakTokenParsed } from 'keycloak-js';
import { KEYCLOAK_CONFIG } from '../config/keycloak.config';

@Injectable({
  providedIn: 'root'
})
export class KeycloakService {
  private keycloak: Keycloak | null = null;
  
  // Reactive signals
  private authenticatedSignal = signal<boolean>(false);
  private userProfileSignal = signal<KeycloakProfile | null>(null);
  private tokenSignal = signal<string | null>(null);
  private rolesSignal = signal<string[]>([]);
  private initializedSignal = signal<boolean>(false);

  private initErrorSignal = signal<string | null>(null);

  public readonly isAuthenticated = computed(() => this.authenticatedSignal());
  public readonly userProfile = computed(() => this.userProfileSignal());
  public readonly token = computed(() => this.tokenSignal());
  public readonly roles = computed(() => this.rolesSignal());
  public readonly isInitialized = computed(() => this.initializedSignal());
  public readonly initError = computed(() => this.initErrorSignal());

  /**
   * Inicializa la instancia de Keycloak
   */
  public async init(): Promise<boolean> {
    if (this.initializedSignal()) {
      return this.authenticatedSignal();
    }

    try {
      this.keycloak = new Keycloak({
        url: KEYCLOAK_CONFIG.url,
        realm: KEYCLOAK_CONFIG.realm,
        clientId: KEYCLOAK_CONFIG.clientId
      });

      // Configurar eventos
      this.keycloak.onTokenExpired = () => {
        this.updateToken(30).catch(err => {
          console.warn('[Keycloak] Fallo al renovar el token expirado:', err);
        });
      };

      this.keycloak.onAuthLogout = () => {
        this.authenticatedSignal.set(false);
        this.tokenSignal.set(null);
        this.userProfileSignal.set(null);
        this.rolesSignal.set([]);
      };

      // Inicialización con login-required directo sin verificación por iframe para evitar bloqueos cross-domain
      const authenticated = await this.keycloak.init({
        onLoad: 'login-required',
        checkLoginIframe: false,
        enableLogging: true,
        pkceMethod: 'S256'
      });

      this.authenticatedSignal.set(authenticated);
      this.initializedSignal.set(true);
      this.initErrorSignal.set(null);

      if (authenticated) {
        this.tokenSignal.set(this.keycloak.token || null);
        this.rolesSignal.set(this.extractRoles());

        try {
          const profile = await this.keycloak.loadUserProfile();
          this.userProfileSignal.set(profile);
        } catch (profileErr) {
          console.warn('[Keycloak] Perfil cargado desde claims de token JWT:', profileErr);
        }
      }

      return authenticated;
    } catch (error: any) {
      console.error('[Keycloak] Error durante la inicialización:', error);
      const errorMsg = error?.error_description || error?.message || error?.error || 'Error al conectar con el servidor de autenticación Keycloak';
      this.initErrorSignal.set(errorMsg);
      this.initializedSignal.set(true);
      this.authenticatedSignal.set(false);
      return false;
    }
  }

  /**
   * Extrae todos los roles (Realm y Client/Resource) del token
   */
  private extractRoles(): string[] {
    if (!this.keycloak) return [];
    const token: any = this.keycloak.tokenParsed;
    
    // Roles de Realm
    const realmRoles: string[] = token?.realm_access?.roles || this.keycloak.realmAccess?.roles || [];
    
    // Roles de Recursos / Clientes
    const clientRoles: string[] = [];
    const resAccess = token?.resource_access || this.keycloak.resourceAccess || {};
    Object.keys(resAccess).forEach(clientKey => {
      const roles = resAccess[clientKey]?.roles;
      if (Array.isArray(roles)) {
        clientRoles.push(...roles);
      }
    });

    const directRoles: string[] = Array.isArray(token?.roles) ? token.roles : [];

    return Array.from(new Set([...realmRoles, ...clientRoles, ...directRoles]));
  }

  public isLoggedIn(): boolean {
    return this.authenticatedSignal();
  }

  public async getToken(): Promise<string | null> {
    if (!this.keycloak || !this.authenticatedSignal()) return null;

    if (this.keycloak.isTokenExpired(30)) {
      try {
        await this.updateToken(30);
      } catch {
        return null;
      }
    }
    return this.keycloak.token || null;
  }

  public async updateToken(minValidity: number = 30): Promise<boolean> {
    if (!this.keycloak) return false;
    try {
      const refreshed = await this.keycloak.updateToken(minValidity);
      if (refreshed) {
        this.tokenSignal.set(this.keycloak.token || null);
      }
      return refreshed;
    } catch (err) {
      console.error('[Keycloak] Error actualizando token:', err);
      return false;
    }
  }

  public getTokenParsed(): KeycloakTokenParsed | undefined {
    return this.keycloak?.tokenParsed;
  }

  public getUserRoles(): string[] {
    return this.rolesSignal();
  }

  public hasRole(role: string): boolean {
    const target = role.trim().toLowerCase();
    return this.rolesSignal().some(r => r.trim().toLowerCase() === target);
  }

  public hasAnyRole(roles: string[]): boolean {
    const userRoles = this.rolesSignal();
    return roles.some(role => userRoles.includes(role));
  }

  public getKeycloakInstance(): Keycloak | null {
    return this.keycloak;
  }

  public login(options?: Keycloak.KeycloakLoginOptions): Promise<void> {
    if (!this.keycloak) {
      this.keycloak = new Keycloak({
        url: KEYCLOAK_CONFIG.url,
        realm: KEYCLOAK_CONFIG.realm,
        clientId: KEYCLOAK_CONFIG.clientId
      });
    }
    return this.keycloak.login({
      redirectUri: `${window.location.origin}/admin/inicio`,
      ...options
    });
  }

  public logout(options?: Keycloak.KeycloakLogoutOptions): Promise<void> {
    if (!this.keycloak) {
      return Promise.resolve();
    }
    return this.keycloak.logout({
      redirectUri: `${window.location.origin}/admin/inicio`,
      ...options
    });
  }

  public accountManagement(): Promise<void> {
    if (!this.keycloak) return Promise.resolve();
    return this.keycloak.accountManagement();
  }
}
