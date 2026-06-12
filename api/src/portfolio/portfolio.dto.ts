import {
  IsArray,
  IsBoolean,
  IsIn,
  IsNotEmpty,
  IsOptional,
  IsString,
  IsUrl,
  MaxLength,
  ValidateNested,
} from "class-validator";
import { Type } from "class-transformer";
import { CaseStatus } from "./portfolio.types";

export class MetricDto {
  @IsString()
  @IsNotEmpty()
  label!: string;

  @IsString()
  @IsNotEmpty()
  value!: string;

  @IsOptional()
  @IsString()
  delta?: string;
}

export class CreateCaseDto {
  @IsString()
  @IsNotEmpty()
  @MaxLength(200)
  title!: string;

  @IsOptional()
  @IsString()
  @MaxLength(120)
  client?: string;

  @IsOptional()
  @IsString()
  @MaxLength(80)
  industry?: string;

  @IsOptional()
  @IsArray()
  @IsString({ each: true })
  services?: string[];

  @IsString()
  @IsNotEmpty()
  challenge!: string;

  @IsString()
  @IsNotEmpty()
  solution!: string;

  @IsOptional()
  @IsArray()
  @ValidateNested({ each: true })
  @Type(() => MetricDto)
  results?: MetricDto[];

  @IsOptional()
  @IsUrl()
  coverImage?: string;

  @IsOptional()
  @IsArray()
  @IsUrl({}, { each: true })
  images?: string[];

  @IsOptional()
  @IsArray()
  @IsString({ each: true })
  tags?: string[];

  @IsOptional()
  @IsBoolean()
  featured?: boolean;

  @IsOptional()
  @IsIn(["draft", "published"] satisfies CaseStatus[])
  status?: CaseStatus;
}

export class UpdateCaseDto {
  @IsOptional()
  @IsString()
  @MaxLength(200)
  title?: string;

  @IsOptional()
  @IsString()
  client?: string;

  @IsOptional()
  @IsString()
  industry?: string;

  @IsOptional()
  @IsArray()
  @IsString({ each: true })
  services?: string[];

  @IsOptional()
  @IsString()
  challenge?: string;

  @IsOptional()
  @IsString()
  solution?: string;

  @IsOptional()
  @IsArray()
  @ValidateNested({ each: true })
  @Type(() => MetricDto)
  results?: MetricDto[];

  @IsOptional()
  @IsUrl()
  coverImage?: string;

  @IsOptional()
  @IsArray()
  @IsUrl({}, { each: true })
  images?: string[];

  @IsOptional()
  @IsArray()
  @IsString({ each: true })
  tags?: string[];

  @IsOptional()
  @IsBoolean()
  featured?: boolean;

  @IsOptional()
  @IsIn(["draft", "published"] satisfies CaseStatus[])
  status?: CaseStatus;
}
