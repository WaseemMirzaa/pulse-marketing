import { IsEmail, IsNotEmpty, IsOptional, IsString, MaxLength } from "class-validator";

export class ContactDto {
  @IsString()
  @IsNotEmpty()
  @MaxLength(120)
  name!: string;

  @IsEmail()
  email!: string;

  @IsOptional()
  @IsString()
  @MaxLength(120)
  company?: string;

  @IsString()
  @IsNotEmpty()
  @MaxLength(4000)
  message!: string;
}
