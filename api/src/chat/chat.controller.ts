import { Body, Controller, Post } from "@nestjs/common";
import { Throttle } from "@nestjs/throttler";
import { ChatDto } from "./chat.dto";
import { ChatService } from "./chat.service";

@Controller("api/chat")
export class ChatController {
  constructor(private readonly chat: ChatService) {}

  @Post()
  @Throttle({ short: { limit: 5, ttl: 10_000 }, medium: { limit: 30, ttl: 60_000 } })
  ask(@Body() dto: ChatDto) {
    const reply = this.chat.reply(dto.message);
    return { reply };
  }
}
