export interface User {
    id: number,
    email: string,
    roles: object,
    is_verified: number,
    agreed_terms: number,
    created_at: string,
    updated_at: string,
    // deleted_at: string,
}