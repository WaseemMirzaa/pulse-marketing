import { IsEmail, IsNotEmpty, IsOptional, IsString, MaxLength } from "class-validator";

export class LeadDto {
  @IsEmail()
  email!: string;

  @IsOptional()
  @IsString()
  @IsNotEmpty()
  @MaxLength(120)
  name?: string;

  @IsOptional()
  @IsString()
  @MaxLength(120)
  company?: string;

  @IsOptional()
  @IsString()
  @MaxLength(60)
  source?: string;
}
