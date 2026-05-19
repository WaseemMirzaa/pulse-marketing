import { Module } from "@nestjs/common";
import { HealthModule } from "./health/health.module";
import { ContactModule } from "./contact/contact.module";
import { OfferingsModule } from "./offerings/offerings.module";
import { ChatModule } from "./chat/chat.module";
import { ContentModule } from "./content/content.module";

@Module({
  imports: [HealthModule, ContactModule, OfferingsModule, ChatModule, ContentModule],
})
export class AppModule {}
