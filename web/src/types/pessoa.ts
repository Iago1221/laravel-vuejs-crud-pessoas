export type PessoaTipo = 'fisica' | 'juridica';

export interface Pessoa {
  id: number;
  nome: string;
  tipo: PessoaTipo;
  documento: string;
  telefone: string;
  email: string;
}