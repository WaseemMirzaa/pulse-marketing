import { Module } from "@nestjs/common";
import { ThrottlerModule, ThrottlerGuard } from "@nestjs/throttler";
import { APP_GUARD } from "@nestjs/core";
import { HealthModule } from "./health/health.module";
import { ContactModule } from "./contact/contact.module";
import { OfferingsModule } from "./offerings/offerings.module";
import { ChatModule } from "./chat/chat.module";
import { ContentModule } from "./content/content.module";
import { LeadsModule } from "./leads/leads.module";

@Module({
  imports: [
    ThrottlerModule.forRoot([
      { name: "short", ttl: 1000, limit: 10 },
      { name: "medium", ttl: 60_000, limit: 60 },
      { name: "long", ttl: 3_600_000, limit: 200 },
    ]),
    HealthModule,
    ContactModule,
    OfferingsModule,
    ChatModule,
    ContentModule,
    LeadsModule,
  ],
  providers: [{ provide: APP_GUARD, useClass: ThrottlerGuard }],
})
export class AppModule {}
