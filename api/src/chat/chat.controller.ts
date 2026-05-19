import { Body, Controller, Post } from "@nestjs/common";
import { ChatDto } from "./chat.dto";
import { ChatService } from "./chat.service";

@Controller("api/chat")
export class ChatController {
  constructor(private readonly chat: ChatService) {}

  @Post()
  ask(@Body() dto: ChatDto) {
    const reply = this.chat.reply(dto.message);
    return { reply };
  }
}
