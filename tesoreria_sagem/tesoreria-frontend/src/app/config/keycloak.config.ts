export interface KeycloakConfig {
  url: string;
  realm: string;
  clientId: string;
}

export const KEYCLOAK_CONFIG: KeycloakConfig = {
  url: 'https://auth.emssanareps.co:8443/',
  realm: 'sagas',
  clientId: 'tesoreria-sagem'
};
