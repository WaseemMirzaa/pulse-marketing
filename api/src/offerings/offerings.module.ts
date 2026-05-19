import { Module } from "@nestjs/common";
import { OfferingsController } from "./offerings.controller";

@Module({
  controllers: [OfferingsController],
})
export class OfferingsModule {}
