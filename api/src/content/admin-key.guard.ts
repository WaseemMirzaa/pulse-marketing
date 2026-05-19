import { CanActivate, ExecutionContext, Injectable, UnauthorizedException } from "@nestjs/common";
import { Request } from "express";

@Injectable()
export class AdminKeyGuard implements CanActivate {
  canActivate(context: ExecutionContext): boolean {
    const req = context.switchToHttp().getRequest<Request>();
    const key = req.header("x-admin-key");
    const expected = process.env.ADMIN_KEY ?? "dev-admin-change-me";
    if (!key || key !== expected) {
      throw new UnauthorizedException("Invalid or missing admin key");
    }
    return true;
  }
}
