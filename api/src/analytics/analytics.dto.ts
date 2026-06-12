import { IsIn, IsNotEmpty, IsObject, IsOptional, IsString, MaxLength } from "class-validator";

export type EventName =
  | "page_view"
  | "cta_click"
  | "form_start"
  | "form_submit"
  | "chat_open"
  | "book_call_click"
  | "scroll_depth";

const EVENT_NAMES: EventName[] = [
  "page_view",
  "cta_click",
  "form_start",
  "form_submit",
  "chat_open",
  "book_call_click",
  "scroll_depth",
];

export class TrackEventDto {
  @IsIn(EVENT_NAMES)
  event!: EventName;

  @IsOptional()
  @IsString()
  @MaxLength(500)
  page?: string;

  @IsOptional()
  @IsObject()
  props?: Record<string, unknown>;

  @IsOptional()
  @IsString()
  @IsNotEmpty()
  @MaxLength(64)
  sessionId?: string;
}
